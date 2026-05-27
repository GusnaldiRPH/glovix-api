<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            [
                'name' => 'Pemula',
                'min_exp' => 0,
                'max_exp' => 100,
                'description' => 'Level untuk pemula yang baru memulai belajar investasi',
            ],
            [
                'name' => 'Menengah',
                'min_exp' => 101,
                'max_exp' => 300,
                'description' => 'Level untuk yang sudah memahami dasar-dasar investasi',
            ],
            [
                'name' => 'Mahir',
                'min_exp' => 301,
                'max_exp' => 600,
                'description' => 'Level untuk investor yang sudah berpengalaman',
            ],
            [
                'name' => 'Pro',
                'min_exp' => 601,
                'max_exp' => 999999,
                'description' => 'Level tertinggi untuk investor profesional',
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}