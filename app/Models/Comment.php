<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'post_id',
        'is_banned',
        'user_id'
    ];

    protected $casts = [
        'is_banned' => 'boolean'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBanned($query, $is_banned = 1)
    {
        return $query->where('is_banned', $is_banned);
    }
}
