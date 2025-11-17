<?php

describe('API - Login', function () {
    it('authenticates login details and returns a valid token', function () {
        $response = $this->post(
            route('login'),
            [
                'email' => config('user.email'),
                'password' => config('user.password'),
            ]
        );

        expect($response->status())
            ->toEqual(200)
            ->and($response->json())
            ->toBeArray()
            ->toHaveKey('data')
            ->and($response->json()['data'])
            ->toHaveKey('token')
            ->and($response->json()['data']['token'])
            ->toBeString();
    });

    it('fails with incorrect login details', function () {
        $response = $this->post(
            route('login'),
            [
                'email' => 'fake@gmail.com',
                'password' => '12345678',
            ]
        );

        expect($response->status())
            ->toEqual(401)
            ->and($response->json())
            ->toBeArray()
            ->toHaveKey('error')
            ->and($response->json()['error'])
            ->toEqual('Login details are invalid');
    });
});
