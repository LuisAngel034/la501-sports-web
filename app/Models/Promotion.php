<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'tag',
        'price_text',
        'icon',
        'color_gradient',
        'end_date',
        'active'
    ];
}
