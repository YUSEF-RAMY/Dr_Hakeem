<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // Seed default Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@skindiagnosis.com'],
            [
                'name'     => 'System Admin',
                'password' => bcrypt('password123'),
            ]
        );
        $admin->assignRole('admin');

        // Seed default Doctor User
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@skindiagnosis.com'],
            [
                'name'     => 'Dr. Ahmed Hakeem',
                'password' => bcrypt('password123'),
            ]
        );
        $doctor->assignRole('doctor');

        // Seed default Patient User
        $patient = User::firstOrCreate(
            ['email' => 'patient@skindiagnosis.com'],
            [
                'name'     => 'John Patient',
                'password' => bcrypt('password123'),
            ]
        );
        $patient->assignRole('patient');
    }
}
