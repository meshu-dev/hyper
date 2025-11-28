<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Enums\UserEnum;

describe('API - Blog', function () {
    it('gets a blog by slug', function () {
        Sanctum::actingAs(
            User::find(UserEnum::MESH)
        );

        $response = $this->get(route('blog.get', ['site' => 'devnudge', 'slug' => 'how-to-install-laravel']));

        expect($response->status())
            ->toEqual(200);

        expect($response->json())
            ->toBeArray()
            ->toHaveKey('data');
    });
});
