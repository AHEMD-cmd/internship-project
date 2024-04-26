<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, FilterTrait;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value) . '-'. time();
    }

    public function getMainImageAttribute()
    {
        return $this->image()->main()->first();
    }

    public function scopeSearchByName($query, $name = '')
    {
        if (!empty($name)) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }

    public function remove()
    {
        $images = $this->image()->where('imageable_id', $this->id)->get();
        foreach ($images as $image) {
            Storage::delete("public/$image->image");
            $image->delete();
        }

        $this->posts()->detach();

    }
}
