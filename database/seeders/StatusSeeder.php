<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = Status::ALL;

        foreach ($statuses as $status) {
            Status::query()->create([
                'code' => $status['code'],
                'name' => $status['name'],
            ]);
        }
    }
}
