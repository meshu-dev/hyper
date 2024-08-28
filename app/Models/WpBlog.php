<?php

namespace App\Models;

use App\Models\Wordpress\WpPost as CorcelWpPost;
use App\Models\Wordpress\WpTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class WpBlog extends Model
{
    protected $table = 'wp_blogs';

    protected $fillable = [
        'wp_post_id',
        'wp_category_id'
    ];

    public $timestamps = false;

    public function blog(): MorphOne
    {
        return $this->morphOne(Blog::class, 'blogable');
    }

    public function wpPost(): BelongsTo
    {
        return $this->belongsTo(CorcelWpPost::class, 'wp_post_id', 'ID');
    }

    public function wpCategory(): BelongsTo
    {
        return $this->belongsTo(WpTerm::class, 'wp_category_id', 'term_id');
    }
}
