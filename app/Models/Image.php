<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', 1);
    }

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return 'storage/' . $this->image;
        }

        return null;
    }
}
