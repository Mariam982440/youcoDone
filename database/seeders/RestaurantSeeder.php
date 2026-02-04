<?php
namespace Database\Seeders;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer des catégories de base
        $cat1 = Category::create(['name' => 'Entrées']);
        $cat2 = Category::create(['name' => 'Plats']);
        $cat3 = Category::create(['name' => 'Desserts']);

        // 2. Récupérer le restaurateur créé précédemment
        $owner = User::role('restaurateur')->first();

        // 3. Créer un restaurant
        $restaurant = Restaurant::create([
            'owner_id' => $owner->id,
            'name' => 'La Bonne Table',
            'city' => 'Paris',
            'cuisine_type' => 'Française',
            'capacity' => 50,
            'opening_hours' => [
                'Lundi' => '12:00-22:00',
                'Mardi' => '12:00-22:00',
                'Mercredi' => 'Fermé'
            ],
            'description' => 'Un restaurant chaleureux au cœur de Paris.'
        ]);

        // 4. Ajouter un Menu et des Plats
        $menu = Menu::create([
            'restaurant_id' => $restaurant->id,
            'title' => 'Menu Dégustation',
            'description' => 'Un assortiment de nos meilleurs plats.'
        ]);

        Dish::create([
            'menu_id' => $menu->id,
            'category_id' => $cat1->id,
            'name' => 'Soupe à l\'oignon',
            'price' => 12.50,
            'is_available' => true
        ]);

        Dish::create([
            'menu_id' => $menu->id,
            'category_id' => $cat2->id,
            'name' => 'Boeuf Bourguignon',
            'price' => 24.00,
            'is_available' => true
        ]);
    }
}