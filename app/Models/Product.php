<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category', 'image', 'available'];

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class, 'product_id');
    }
}