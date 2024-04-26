<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specification extends Model
{
    use HasFactory, FilterTrait;

    protected $fillable = [
        'name',
    ];

    public function scopeSearchByName($query, $name = '')
    {
        if (!empty($name)) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }

    public function places()
    {
        return $this->belongsToMany(Place::class)->withPivot('value');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getMainImageAttribute()
    {
        return $this->image()->main()->first();
    }

    public function remove()
    {
        $images = $this->image()->where('imageable_id', $this->id)->get();
        foreach ($images as $image) {
            Storage::delete("public/$image->image");
            $image->delete();
        }

        $this->places()->detach();
    }
}
