<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    protected $table = 'youtube_videos';

    protected $fillable = [
        'youtube_id',
        'title',
        'thumbnail_url',
        'published_at',
    ];
}
