<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Enums\UserEnum;

describe('API - Blog', function () {
    it('searches for blogs', function () {
        Sanctum::actingAs(
            User::find(UserEnum::MESH)
        );

        $response = $this->get(route('blog.search', ['site' => 'devnudge', 'search' => 'laravel']));

        expect($response->status())
            ->toEqual(200);

        expect($response->json())
            ->toBeArray()
            ->toHaveKey('data');
    });
});
