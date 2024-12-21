<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'description' => 'Administrateur de la plateforme']);
        Role::create(['name' => 'porteur de projet', 'description' => 'Utilisateur avec un projet']);
        Role::create(['name' => 'coach', 'description' => 'Mentor ou coach pour les projets']);
    }
}
