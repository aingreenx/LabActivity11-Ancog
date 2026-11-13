<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $fillable = ['name', 'position', 'email', 'user_id'];

    /** Inverse of User hasOne Author; the FK user_id lives on authors. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /** Comments on this author's posts: authors -> posts.author_id -> comments.post_id. */
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }
}
