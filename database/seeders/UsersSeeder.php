<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::factory([
            'name' => "inrock",
            'email' => "inrock@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make('azerty'),
            'remember_token' => Str::random(10),
        ])->create();
        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'name' => $name = 'user' . $i,
                'email' => "$name@gmail.com",
                'password' => Hash::make('azerty'),
            ]);
        }
    }
}
