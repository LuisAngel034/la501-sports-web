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

    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }
        if (str_contains($value, 'res.cloudinary.com') && str_contains($value, '/upload/')) {
            if (!str_contains($value, 'q_auto')) {
                return str_replace('/upload/', '/upload/f_auto,q_auto/', $value);
            }
        }
        return $value;
    }
}
