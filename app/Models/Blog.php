<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
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
