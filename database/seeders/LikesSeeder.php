<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use App\Models\Voyage;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Factory::create('fr_FR');

        $articles = Article::all();
        foreach($articles as $article) {
            $nbLikes = $faker->numberBetween(2, 10);
            $userIds = User::pluck('id');
            $userIdsSelected = $faker->randomElements($userIds, $nbLikes);
            $article->likes()->attach($userIdsSelected);
        }
    }
}
