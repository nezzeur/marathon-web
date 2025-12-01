<?php

namespace Database\Seeders;

use App\Models\Accessibilite;
use App\Models\Audience;
use App\Models\Conclusion;
use App\Models\Rythme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = [
            "Je me suis endormi dans mon fauteuil",
            "Ne me perturbe pas quand je lis en même temps",
            "Mes pieds se mettent à bouger",
            "Je me lève et je fais la danse de l’épaule",
            "Mes enfants sautent comme des cabris dans la pièce",
        ];

        foreach ($table as $t)
            Rythme::create(['texte' => $t]);

        $table = [
            "Après plusieurs écoutes je n’ai toujours pas saisi la mélodie",
            "Plusieurs écoutes sont nécessaires avant d’apprécier la mélodie",
            "Mélodie agréable mais sans aspérité",
            "Les refrains entrent directement dans ma tête",
            "Que des hits taillés pour les stades"
        ];

        foreach ($table as $t)
            Accessibilite::create(['texte' => $t]);

        $table = [
            "Je l’ai écouté une fois mais c’est une fois de trop",
            "Après plusieurs écoutes j’ai du mal à m’y faire",
            "Je l’écoute facilement mais sans émotion",
            "J’ai beaucoup de plaisir à l’écouter",
            "Il tourne en  boucle sur ma platine"
        ];
        foreach ($table as $t)
            Conclusion::create(['texte' => $t]);


        $table = [
            "Accessible à tout le monde",
            "Peut être écouté en famille",
            "Seuls vos vrais amis comprennent le sens de cette musique",
            "Tellement bizarre que je préfère être seul pour l'écouter",
        ];
        foreach ($table as $t)
            Audience::create(['texte' => $t]);
    }

}
