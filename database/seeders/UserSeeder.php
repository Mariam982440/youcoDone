<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $restaurateur = User::create([
            'name' => 'Chef Gourmand',
            'email' => 'resto@test.com',
            'password' => Hash::make('restau1234'),
        ]);
        $restaurateur->assignRole('restaurateur');

        $client = User::create([
            'name' => 'Jean Client',
            'email' => 'client@test.com',
            'password' => Hash::make('client1234'),
        ]);
        $client->assignRole('client');

        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@youcode.ma',
            'password' => Hash::make('admin1234'),
        ]);
        $admin->assignRole('admin');
    }
}
?>