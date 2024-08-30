<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'site_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }

    public function blogable(): MorphTo
    {
        return $this->morphTo();
    }
}
