<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NetworkSeeder::class);
        $this->call(RiskLevelSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SourceSeeder::class);
    }
}
