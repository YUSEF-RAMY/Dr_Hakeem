<?php

namespace Database\Seeders;

use App\Enums\RiskLevel;
use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use App\Models\Diagnosis;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with default users, profiles, and sample scan diagnoses.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // 1. Primary Patient User (Salma Mohamed - Backend Developer)
        $patientUser = User::firstOrCreate(
            ['email' => 'salma.mohamed@example.com'],
            [
                'name'     => 'سلمى محمد',
                'password' => bcrypt('Password123!'),
            ]
        );
        $patientUser->assignRole('patient');

        PatientProfile::firstOrCreate(
            ['user_id' => $patientUser->id],
            [
                'patient_code'     => 'PAT-A8F2K1',
                'age'              => 25,
                'blood_group'      => 'A+',
                'skin_type'        => 'Type II',
                'conditions'       => [],
                'active_allergies' => [],
                'settings'         => [
                    'notifications_enabled' => true,
                    'dark_mode'             => true,
                    'language'              => 'ar',
                ],
            ]
        );

        // 2. Doctor User
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@skindiagnosis.com'],
            [
                'name'     => 'د. حكيم علي',
                'password' => bcrypt('Password123!'),
            ]
        );
        $doctorUser->assignRole('doctor');

        PatientProfile::firstOrCreate(
            ['user_id' => $doctorUser->id],
            [
                'patient_code'     => 'DOC-1001',
                'age'              => 42,
                'blood_group'      => 'O+',
                'skin_type'        => 'Type III',
                'conditions'       => [],
                'active_allergies' => [],
                'settings'         => [
                    'notifications_enabled' => true,
                    'dark_mode'             => true,
                    'language'              => 'ar',
                ],
            ]
        );

        // 3. System Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@skindiagnosis.com'],
            [
                'name'     => 'مدير النظام',
                'password' => bcrypt('Password123!'),
            ]
        );
        $adminUser->assignRole('admin');

        PatientProfile::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'patient_code'     => 'ADM-0001',
                'age'              => 38,
                'blood_group'      => 'AB+',
                'skin_type'        => 'Type II',
                'conditions'       => [],
                'active_allergies' => [],
                'settings'         => [
                    'notifications_enabled' => true,
                    'dark_mode'             => true,
                    'language'              => 'ar',
                ],
            ]
        );

        // 4. Secondary Patient User
        $patientUser2 = User::firstOrCreate(
            ['email' => 'patient@skindiagnosis.com'],
            [
                'name'     => 'علي حسن',
                'password' => bcrypt('Password123!'),
            ]
        );
        $patientUser2->assignRole('patient');

        PatientProfile::firstOrCreate(
            ['user_id' => $patientUser2->id],
            [
                'patient_code'     => 'PAT-998822',
                'age'              => 28,
                'blood_group'      => 'B+',
                'skin_type'        => 'Type IV',
                'conditions'       => ['Asthma'],
                'active_allergies' => ['Aspirin'],
                'settings'         => [
                    'notifications_enabled' => true,
                    'dark_mode'             => false,
                    'language'              => 'ar',
                ],
            ]
        );
    }
}
