<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userCount = max((int)$this->command->ask('How many users would you like?', 20), 1);

        \App\Models\User::factory($userCount)->create();
        \App\Models\User::factory()->oscarChiu()->create();
    }
}
