<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Article;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Nettoyer les tables relacionadas
        \DB::table('suivis')->delete();
        \DB::table('likes')->delete();
        \DB::table('avis')->delete();
        \DB::table('articles')->delete();
        User::query()->delete();

        $hash = Hash::make('azerty');

        // Créer l'utilisateur de test
        User::firstOrCreate(
            ['email' => 'inrocks@gmail.com'],
            [
                'name' => 'inrocks',
                'email_verified_at' => now(),
                'password' => $hash,
            ]
        );

        // Créer 50 utilisateurs supplémentaires
        for ($i = 1; $i <= 50; $i++) {
            $name = 'user' . $i;
            User::firstOrCreate(
                ['email' => "$name@gmail.com"],
                [
                    'name' => $name,
                    'email_verified_at' => now(),
                    'password' => $hash,
                ]
            );
        }

        $faker = Factory::create('fr_FR');

        // Créer les suivis
        $users = User::all();
        foreach($users as $user) {
            $nb = $faker->numberBetween(2, 10);
            $userIds = User::where('id', '!=', $user->id)->pluck('id')->toArray();
            $userIdsSelected = $faker->randomElements($userIds, min($nb, count($userIds)));
            $user->suivis()->attach($userIdsSelected);
        }
    }
}
