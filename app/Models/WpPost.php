<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Wordpress\WpPost as CorcelWpPost;

class WpPost extends Model
{
    use SoftDeletes;

    protected $table = 'wp_posts';

    protected $fillable = [
        'wp_post_id',
        'wp_category_id',
        'title',
        'slug',
        'content',
        'published_at'
    ];

    public function wpPost(): BelongsTo
    {
        return $this->belongsTo(CorcelWpPost::class, 'wp_post_id', 'ID');
    }
}
