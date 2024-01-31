<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Vulnerabilidades Internas',
            'Pentest Externo',
        ];

        foreach ($sources as $source) {
            Source::query()->create(['name' => $source]);
        }
    }
}
