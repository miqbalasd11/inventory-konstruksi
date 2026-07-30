<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuickUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            'admin@example.com' => [
                'name' => 'Super Admin',
                'role' => 'Super Admin',
            ],
            'gudang@example.com' => [
                'name' => 'Admin Gudang',
                'role' => 'Admin Gudang',
            ],
            'proyek@example.com' => [
                'name' => 'Staff Proyek',
                'role' => 'Staff Proyek',
            ],
            'manager@example.com' => [
                'name' => 'Manajer Proyek',
                'role' => 'Manajer Proyek',
            ],
        ];

        foreach ($users as $email => $data) {
            $role = Role::firstOrCreate(['name' => $data['role']]);

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]
            );
        }
    }
}
