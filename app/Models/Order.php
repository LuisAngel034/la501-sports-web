<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_email',
        'tracking_token',
        'table_number',
        'total',
        'status',
        'delivery_started_at',
        'delivered_confirmed_at',
        'last_reminder_sent_at',
        'payment_method',
        'payment_id',
        'waiter_id',
        'charged_by',
        'forced_checkout',
        'forced_checkout_reason',
    ];

    protected $casts = [
        'forced_checkout' => 'boolean',
        'delivery_started_at' => 'datetime',
        'delivered_confirmed_at' => 'datetime',
        'last_reminder_sent_at' => 'datetime',
    ];

    /**
     * El pedido es "a domicilio" cuando no tiene mesa asignada.
     */
    public function esADomicilio(): bool
    {
        return empty($this->table_number);
    }

    /**
     * Correo al que se le puede notificar sobre este pedido (registrado o invitado).
     */
    public function correoNotificacion(): ?string
    {
        if ($this->user_id && $this->user && $this->user->email) {
            return $this->user->email;
        }

        return $this->customer_email ?: null;
    }

    /**
     * Genera el token si el pedido es de antes de que existiera esta función.
     */
    public function trackingToken(): string
    {
        if (empty($this->tracking_token)) {
            $this->tracking_token = Str::random(48);
            $this->save();
        }

        return $this->tracking_token;
    }

    /**
     * Pedidos que cuentan como venta cobrada (para reportes/estadísticas).
     */
    public function scopeVendidas($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'paid')
              ->orWhere(function ($sq) {
                  $sq->whereNull('table_number')
                     ->whereIn('status', ['ready', 'delivering', 'delivered']);
              });
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function chargedBy()
    {
        return $this->belongsTo(User::class, 'charged_by');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->tracking_token)) {
                $order->tracking_token = Str::random(48);
            }
        });

        static::updated(function ($order) {
            if ($order->isDirty('status') && $order->status === 'paid') {
                $order->discountInventoryStock();
            }
        });

        static::created(function ($order) {
            if ($order->status === 'paid') {
                $order->discountInventoryStock();
            }
        });
    }

    public function discountInventoryStock()
    {
        $this->load('items.product.ingredientes');

        foreach ($this->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }

            $excluded = is_array($item->excluded_ingredients)
                ? $item->excluded_ingredients
                : json_decode($item->excluded_ingredients, true) ?? [];

            foreach ($product->ingredientes as $ingrediente) {
                if ($ingrediente->inventory_id) {
                    $isExcluded = collect($excluded)->contains(function ($value) use ($ingrediente) {
                        return strtolower(trim($value)) === strtolower(trim($ingrediente->nombre));
                    });

                    if (!$isExcluded) {
                        $qtyToDiscount = $item->quantity * $ingrediente->cantidad_usada;
                        
                        $inventory = \App\Models\Inventory::find($ingrediente->inventory_id);
                        if ($inventory) {
                            $inventory->current_stock = max(0, $inventory->current_stock - $qtyToDiscount);
                            $inventory->save();
                        }
                    }
                }
            }
        }
    }
}
