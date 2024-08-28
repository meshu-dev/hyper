<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class NotionBlog extends Model
{
    protected $table = 'notion_blogs';

    protected $fillable = [
        'notion_page_id'
    ];

    public $timestamps = false;

    public function blog(): MorphOne
    {
        return $this->morphOne(Blog::class, 'blogable');
    }
}
