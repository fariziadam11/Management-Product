<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the permission seeder first to create roles and permissions
        $this->call([
            PermissionSeeder::class,
        ]);
        
        // Add other seeders here as needed
    }
}
