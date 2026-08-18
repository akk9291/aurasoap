<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@aurasoaps.com'],
            [
                'name' => 'Aura Super Admin',
                'phone' => '+1 (800) 555-AURA',
                'status' => 'active',
                'password' => Hash::make('Password123!'),
            ]
        );

        $superRole = Role::where('slug', 'super-admin')->first();
        if ($superRole) {
            $superAdmin->roles()->syncWithoutDetaching([$superRole->id]);
        }
    }
}
