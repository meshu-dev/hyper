<?php

namespace App\Models\Wordpress;

use Corcel\Model\Taxonomy as Corcel;

class WpTaxonomy extends Corcel
{
    protected $connection = 'wordpress';
}
