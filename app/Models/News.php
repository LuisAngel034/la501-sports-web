<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'image',
        'active',
        'start_date',
        'end_date'
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
