<?php

namespace Database\Seeders;

use App\Models\Rythme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RythmeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rythmes = [
            ['texte' => 'Lent et relaxant', 'image' => null],
            ['texte' => 'Modéré et équilibré', 'image' => null],
            ['texte' => 'Rapide et énergique', 'image' => null],
            ['texte' => 'Variable et dynamique', 'image' => null],
            ['texte' => 'Méditatif et calme', 'image' => null],
        ];

        foreach ($rythmes as $rythme) {
            Rythme::create($rythme);
        }
    }
}