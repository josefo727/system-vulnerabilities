<?php

namespace Database\Seeders;

use App\Models\RiskLevel;
use Illuminate\Database\Seeder;

class RiskLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Bajo',
                'values' => [1, 2],
                'days_to_add' => 240,
            ],
            [
                'name' => 'Medio bajo',
                'values' => [3, 4],
                'days_to_add' => 180,
            ],
            [
                'name' => 'Medio',
                'values' => [5],
                'days_to_add' => 90,
            ],
            [
                'name' => 'Medio alto',
                'values' => [6, 7],
                'days_to_add' => 45,
            ],
            [
                'name' => 'Alto',
                'values' => [8],
                'days_to_add' => 30,
            ],
        ];

        foreach ($levels as $level) {
            RiskLevel::query()->create($level);
        }
    }
}
