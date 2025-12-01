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
        $nbLikes = $faker->numberBetween(2, 10);
        $userIds = User::pluck('id');
        $userIdsSelected = $faker->randomElements($userIds, $nbLikes);
        $article = Article::first();
        $article->likes()->attach($userIdsSelected);
    }
}
