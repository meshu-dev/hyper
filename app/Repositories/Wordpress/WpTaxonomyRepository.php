<?php

namespace App\Repositories\Wordpress;

use App\Models\Wordpress\WpTaxonomy;

class WpTaxonomyRepository
{
    public function getCategories()
    {
        $taxomyCategories = WpTaxonomy::where('taxonomy', 'category')->get();
        $terms = [];

        foreach ($taxomyCategories as $taxomyCategory) {
            $terms[] = $taxomyCategory->term;
        }
        return $terms;
    }
}