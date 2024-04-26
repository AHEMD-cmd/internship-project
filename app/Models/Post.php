<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
	use HasFactory, FilterTrait;

	protected $fillable = [
		'title',
        'slug',
		'description',
		'is_visible',
		'user_id'
	];

    protected $casts = [
        'is_visible' => 'boolean'
    ];

    public function scopeSearchByName($query, $title = '')
    {
        if (!empty($title)) {
            return $query->where('title', 'like', '%' . $title . '%');
        }
    }

    public function scopeVisible($query, $is_visible = 1)
    {
        return $query->where('is_visible', $is_visible);
    }

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value) . '-' . time();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getMainImageAttribute()
    {
        return $this->images()->main()->first();
    }

    //remove post's images
    public function remove()
    {
        $images = $this->images()->where('imageable_id', $this->id)->get();
        foreach ($images as $image) {
            Storage::delete("public/$image->image");
            $image->delete();
        }

        $this->categories()->detach();
    }
}
