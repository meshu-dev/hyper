<?php

namespace App\Contracts;

interface NotionTransformer
{
    public function transform(): string;
}
