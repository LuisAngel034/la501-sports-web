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
        'table_number',    // <--- ¡ESTO ES LO QUE SEGURAMENTE FALTA!
        'total',
        'status',
        'payment_method',
        'payment_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}