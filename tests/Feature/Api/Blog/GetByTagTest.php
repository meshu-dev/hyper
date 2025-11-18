<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Enums\TagEnum;
use Tests\Enums\UserEnum;

describe('API - Blog', function () {
    it('gets a list of blogs by a tag', function () {
        Sanctum::actingAs(
            User::find(UserEnum::MESH)
        );

        $response = $this->get(route('blog.tag', ['site' => 'devnudge', 'tag' => TagEnum::LARAVEL]));

        expect($response->status())
            ->toEqual(200);

        expect($response->json())
            ->toBeArray()
            ->toHaveKey('data');
    });
});
