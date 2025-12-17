<?php

namespace Database\Seeders;

use App\Models\Conclusion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConclusionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conclusions = [
            ['texte' => 'Apaisement et relaxation profonde', 'image' => null],
            ['texte' => 'Énergie et vitalité retrouvée', 'image' => null],
            ['texte' => 'Équilibre corps-esprit', 'image' => null],
            ['texte' => 'Amélioration de la concentration', 'image' => null],
            ['texte' => 'Sensation de bien-être général', 'image' => null],
        ];

        foreach ($conclusions as $conclusion) {
            Conclusion::create($conclusion);
        }
    }
}