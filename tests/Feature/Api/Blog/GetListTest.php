<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Enums\UserEnum;

describe('API - Blog', function () {
    it('gets a list of blogs', function () {
        Sanctum::actingAs(
            User::find(UserEnum::MESH)
        );

        $response = $this->get(route('blog.list', ['site' => 'devnudge']));

        expect($response->status())
            ->toEqual(200);

        expect($response->json())
            ->toBeArray()
            ->toHaveKey('data');
    });
});
