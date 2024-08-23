<?php

namespace App\Models\Wordpress;

use Corcel\Model\Post as Corcel;

class WpPost extends Corcel
{
    protected $connection = 'wordpress';
}
