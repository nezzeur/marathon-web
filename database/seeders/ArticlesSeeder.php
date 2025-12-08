<?php

namespace Database\Seeders;

use App\Models\Article;

use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Factory::create('fr_FR');

        $titre = "Au clair de la lune";

        $texte = "Ah, Au clair de la lune, cette ballade intemporelle où l’on découvre que la première urgence, au XVIIIᵉ siècle, n’était ni la faim, ni la guerre, ni même la météo… mais un manque de bougie. Le héros, manifestement équipé d’une mémoire de poisson rouge, se retrouve plongé dans l’obscurité totale et décide d’aller sonner chez son voisin Pierrot, spécialiste incontesté de la gestion d’inventaire… enfin, c’est ce qu’il espère. Pierrot, bien sûr, dort. Car personne ne dort jamais dans une chanson, sauf quand on a besoin d’une bougie.<br />

Après quoi, la quête du luminaire devient soudain une tragicomédie du quotidien : on gratte, on cherche, on soupire… et on réalise que toute l'intrigue repose sur un objet disparu qui aurait pu être remplacé par absolument n’importe quoi. Une torche ? Une lanterne ? Une luciole motivée ? Non. Il faut une bougie. Et tant pis si l’on réveille tout le voisinage au passage.<br />

Cette chanson, finalement, est une sorte de tutoriel poétique sur le thème : “Comment créer du drame avec un accessoire à deux sous.” Et ça fonctionne encore aujourd’hui, car rien n’est plus universel que de chercher quelque chose dans le noir, de ne pas le trouver, et d’accuser un ami innocent au passage.<br />

Bref : une aventure nocturne minimaliste, un suspense à hauteur d’enfant, et une morale simple — mieux vaut vérifier sa réserve de bougies avant l’heure du coucher.<br />";

        $resume = "Un homme cherche désespérément une bougie dans la nuit et finit par réveiller tout son entourage pour résoudre un minuscule problème d’éclairage.";

        Article::create([
            'titre' => $titre,
            'resume' => $resume,
            'texte' => $texte,
            'image' => '/images/au-clair-de-la-lune.jpg',
            'media' => 'https://comptines.tv/musiques/au_clair_de_la_lune.mp3',
            "en_ligne" => 1,
            "user_id" => 1,
            "rythme_id" => 1,
            "accessibilite_id" => 3,
            "conclusion_id" => 1,
          
        ]);

        for($i = 1; $i <= 50; $i++)
            Article::create([
                'titre' => $faker->text(20),
                'resume' => $faker->realTextBetween(30, 100,  2),
                'texte' => $faker->realTextBetween(160, 500,  2),
                'image' => "/images/article$i.png",
                'media' => 'https://comptines.tv/musiques/au_clair_de_la_lune.mp3',
                "user_id" =>  $faker->numberBetween(1, 50),
                "rythme_id" => $faker->numberBetween(1, 5),
                "accessibilite_id" => $faker->numberBetween(1, 5),
                "conclusion_id" => $faker->numberBetween(1, 5),
                "en_ligne" => $faker->numberBetween(0,1),

            ]);
    }
}
