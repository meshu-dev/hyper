<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'site_id',
        'notion_tag_id',
        'name',
        'color',
    ];

    public $timestamps = false;

    /**
     * @return BelongsToMany<Blog, $this>
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_tags', 'tag_id', 'blog_id');
    }
}
