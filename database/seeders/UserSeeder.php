<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $restaurateur = User::create([
            'name' => 'Chef Gourmand',
            'email' => 'resto@test.com',
            'password' => Hash::make('password'),
        ]);
        $restaurateur->assignRole('restaurateur');

        $client = User::create([
            'name' => 'Jean Client',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
        ]);
        $client->assignRole('client');
    }
}
?>