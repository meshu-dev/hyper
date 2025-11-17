<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::count()) {
            User::create([
                'name'     => config('user.name'),
                'email'    => config('user.email'),
                'password' => Hash::make(config('user.password')),
            ]);
        }
    }
}
