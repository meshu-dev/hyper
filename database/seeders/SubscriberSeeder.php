<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubscriberSeeder extends Seeder
{
    public function run(): void
    {
        Subscriber::insert([
            array_merge($this->getFields(), ['sent' => 1, 'deleted_at' => null]),
            array_merge($this->getFields(), ['sent' => 1, 'deleted_at' => null]),
            array_merge($this->getFields(), ['sent' => 0, 'deleted_at' => null]),
            array_merge($this->getFields(), ['sent' => 0, 'deleted_at' => Carbon::now()])
        ]);
    }

    protected function getFields()
    {
        return [
            'name'       => fake()->name(),
            'email'      => fake()->email(),
            'ip'         => fake()->localIpv4(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
