<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Avis;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AvisSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        $articles = Article::all();
        foreach ($articles as $a) {
            $nbAvis = $faker->numberBetween(5, 10);

            $userIds = User::pluck('id');
            $userIdsSelected = $faker->randomElements($userIds, $nbAvis);
            for ($i = 0; $i < $nbAvis; $i++) {
                $contenu = $faker->sentence(10);
                $created_at = $faker->dateTimeInInterval(
                    '-3 months',
                    '+ 90 days',
                    date_default_timezone_get()
                );
                $updated_at = $created_at;

                Avis::create([
                    'contenu' => $contenu,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                    'user_id' => $userIdsSelected[$i],
                    'article_id' => $a->id,
                ]);
            }
        }
    }
}
