<?php

describe('API - Newsletter', function () {
    it('registers a new subscriber', function () {
        $name = 'Tony Stark';
        $email = 'tonystark@gmail.com';

        $response = $this->postJson(
            route('newsletter.signup'),
            [
                'name' => $name,
                'email' => $email,
            ]
        );

        expect($response->status())->toEqual(200);

        $this->assertDatabaseHas('subscribers', [
            'name' => $name,
            'email' => $email,
        ]);
    });
});
