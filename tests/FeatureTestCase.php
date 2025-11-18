<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

abstract class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    public $seed = true;
}
