<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, FilterTrait;

    protected $fillable = [
        'name',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '_', $value);
    }

    public function scopeVisible($query, $is_visible = 1)
    {
        return $query->where('is_visible', $is_visible);
    }

    public function scopeSearchByName($query, $name)
    {
        if (!empty($name)) {
            return $query->where('name', 'like', '%' . str_replace(' ', '_', $name) . '%');
        }
    }

    public function places()
    {
        return $this->morphedByMany(Place::class, 'taggable');
    }
}
