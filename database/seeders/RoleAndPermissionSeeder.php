<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'create-scan',
            'view-own-scans',
            'view-all-scans',
            'delete-own-scan',
            'delete-any-scan',
            'manage-users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Patient Role
        $patientRole = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);
        $patientRole->syncPermissions([
            'create-scan',
            'view-own-scans',
            'delete-own-scan',
        ]);

        // Create Doctor Role
        $doctorRole = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        $doctorRole->syncPermissions([
            'create-scan',
            'view-own-scans',
            'view-all-scans',
            'delete-own-scan',
        ]);

        // Create Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());
    }
}
