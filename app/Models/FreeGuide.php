<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class FreeGuide extends Model
{
    protected $fillable = [
        'name',
        'filename',
    ];
}
