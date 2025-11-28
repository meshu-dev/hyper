<?php

namespace App\Models;

use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    /** @use HasFactory<BlogFactory> */
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'site_id',
        'notion_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }
}
