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

        // Liste des musiques disponibles pour la génération aléatoire
        $musiques = [
            'musiques/au_clair_de_la_lune.mp3',
            'musiques/frere_jacques.mp3',
            'musiques/twinkle_twinkle.mp3',
            'musiques/mary_had_lamb.mp3',
            'musiques/old_macdonald.mp3',
            'musiques/baa_baa_black_sheep.mp3',
        ];

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
            'media' => 'musiques/au_clair_de_la_lune.mp3',
            "en_ligne" => 1,
            "nb_vues" => 50,
            "user_id" => 1,
            "rythme_id" => 1,
            "accessibilite_id" => 3,
            "conclusion_id" => 1,
          
        ]);

        Article::create([
            'titre' => 'Sonic Colors : la musique en mode supersonique !',
            'resume' => 'Il y a des studios qui ne cherchent pas à réinventer le gaming, mais au moins à lui donner un gros coup de boost, à la vitesse du son. C’est le cas de SEGA avec Sonic Colors, un jeu où l’on retrouve notre petit hérisson bleu favori aussi bien sur console de salon que sur console portable. Une explosion de couleurs, de pixels et d’adrénaline, un retour à l’identité rétro-futuriste de Sonic après l’ambition plus réaliste de Unleashed. Dès les premières secondes, le ton est donné: ça va vite, ça brille, on n’a pas le temps de s’ennuyer.',
            'texte' => 'L’idée géniale de Sonic Colors réside dans les Wisps. Ces nouvelles petites créatures que Sonic tente de libérer des mains du Dr. Robotnik, qui cherche à exploiter leur pouvoir. Heureusement, notre hérisson bleu préféré peut compter sur son ami Tails, ainsi que sur les pouvoirs temporaires que lui procurent les Wisps, renouvelant sans cesse le gameplay : laser, foreuse, boost vertical… Chaque transformation a sa bande-son associée ainsi qu’un style musical si particulier est un prétexte à expérimenter, à casser le rythme pour mieux repartir. Et puis il y a ces combats contre Eggman, stressants et marquants. Parfois frustrants par leur difficulté, mais toujours mémorables grâce à leur musique. Des moments où la vitesse laisse place à la tension, gravant le souvenir dans la mémoire du jeune joueur. Je me rappelle encore être en train de jouer à Sonic Colors sur ma DS, sur le grand...',
            'image' => '/images/sonic.png',
            'media' => 'musiques/sonic_colors.mp3',
            'en_ligne' => 1,
            'nb_vues' => 50,
            'user_id' => 1,
            'rythme_id' => 2,
            'accessibilite_id' => 4,
            'conclusion_id' => 2,
        ]);

        Article::create([
            'titre' => 'Les codes musicaux des jeux vidéo entre immersion et répétition.',
            'resume' => 'Souvent lorsque l’on parle de la qualité d’un jeu vidéo, on pense souvent aux graphismes ou au gameplay, mais en réalité sa qualité ne repose pas seulement sur sa conception, elle repose aussi sur sa bande sonore qui permet une immersion complète pour le joueur dans l’univers du jeu. Toutefois, cette volonté d’immerger le joueur dans l’univers du jeu peut amener les musiques à devenir trop discrète, de ne pas se démarquer ou de laisser peu de souvenirs auditifs. C’est le cas par exemple pour la série phare Assassin’s Creed qui utilise ses musiques pour accompagner le joueur dans son exploration sans jamais prendre les devants.',
            'texte' => 'On retrouve aussi très souvent dans les bandes sonores des jeux, des clichés spécifiques liés au genre du jeu. Dans le genre de série comme Assassin’s Creed, on peut retrouver des codes particuliers tels que l’utilisation des percussions pour souligner la tension ou pour des combats, les nappes orchestrales pour les moments épiques, ou les sonorités électroniques pour les univers futuristes. Selon les compositeurs ces codes sont primordiaux et souvent utilisés pour guider le joueur pendant la partie, mais leur usage constant finit par rendre les musiques épiques, ou les sonorités électroniques pour les univers futuristes. Selon les compositeurs ces codes sont primordiaux et souvent utilisés pour guider le joueur pendant la partie, mais leur usage constant finit par rendre les musiques prévisibles et stéréotypées. Dans d’autres types de jeu comme animal crossing, les bandes sonores adoptent un rythme très répétitif et même si elles sont pensées et composées pour des sessions longues, cette répétition constante peut entraîner une fatigue auditive et réduire le plaisir d’écoute sur le long terme. Ainsi, bien que la musique de jeu vidéo soit conçue pour renforcer l’immersion dans le jeu, elle est très souvent limitée par des attentes liées au genre du jeu, à la répétition des thèmes et à sa discrétion, ce qui peut donner une impression de monotonie ou déjà vu au joueur attentif.',
            'image' => '/images/code.png',
            'media' => 'musiques/code.mp3',
            'en_ligne' => 1,
            'nb_vues' => 50,
            'user_id' => 1,
            'rythme_id' => 2,
            'accessibilite_id' => 4,
            'conclusion_id' => 2,
        ]);

        for($i = 1; $i <= 50; $i++)
            Article::create([
                'titre' => $faker->text(20),
                'resume' => $faker->realTextBetween(30, 100,  2),
                'texte' => $faker->realTextBetween(160, 500,  2),
                'image' => "/images/article$i.png",
                'media' => $faker->randomElement($musiques),
                "user_id" =>  $faker->numberBetween(1, 50),
                "rythme_id" => $faker->numberBetween(1, 5),
                "accessibilite_id" => $faker->numberBetween(1, 5),
                "conclusion_id" => $faker->numberBetween(1, 5),
                "en_ligne" => $faker->numberBetween(0,1),
                "nb_vues" => $faker->numberBetween(0, 20),
            ]);
    }
}
