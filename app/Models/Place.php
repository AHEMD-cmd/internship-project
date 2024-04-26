<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
	use HasFactory, FilterTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value) . '-' . time();
    }

    public function scopeVisible($query, $is_visible = 1)
    {
        return $query->where('is_visible', $is_visible);
    }

    public function scopeSearchByName($query, $name = '')
    {
        if (!empty($name)) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class)->withPivot('value');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->main()->first();
    }

    //remove place's images
    public function remove()
    {
        $images = $this->images()->where('imageable_id', $this->id)->get();
        foreach ($images as $image) {
            Storage::delete("public/$image->image");
            $image->delete();
        }

        $this->tags()->detach();
        $this->specifications()->detach();

    }
}
