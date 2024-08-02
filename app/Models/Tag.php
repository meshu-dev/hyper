<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'notion_tag_id',
        'name',
        'color'
    ];

    public $timestamps = false;
}
