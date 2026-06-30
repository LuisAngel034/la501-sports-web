<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'table_number',
        'total',
        'status',
        'payment_method',
        'payment_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function booted()
    {
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
