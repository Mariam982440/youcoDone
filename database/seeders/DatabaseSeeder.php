<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. On appelle les seeders dans l'ordre logique des dépendances
        $this->call([
            RoleSeeder::class,       // Doit être en premier (pour que les rôles existent)
            UserSeeder::class,       // Crée les utilisateurs et leur assigne des rôles
            RestaurantSeeder::class, // Crée restaurants, menus et plats
        ]);
        
    }
}