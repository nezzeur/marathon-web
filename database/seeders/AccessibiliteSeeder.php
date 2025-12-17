<?php

namespace Database\Seeders;

use App\Models\Accessibilite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessibiliteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessibilites = [
            ['texte' => 'Débutant - Facile à suivre', 'image' => null],
            ['texte' => 'Intermédiaire - Quelques défis', 'image' => null],
            ['texte' => 'Avancé - Technique complexe', 'image' => null],
            ['texte' => 'Tous niveaux - Adaptable', 'image' => null],
            ['texte' => 'Accessible aux personnes à mobilité réduite', 'image' => null],
        ];

        foreach ($accessibilites as $accessibilite) {
            Accessibilite::create($accessibilite);
        }
    }
}