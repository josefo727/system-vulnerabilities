<?php

namespace Database\Seeders;

use App\Models\Network;
use Illuminate\Database\Seeder;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $networks = ['PCI', 'CORP'];

        foreach ($networks as $network) {
            Network::query()->create(['name' => $network]);
        }
    }
}
