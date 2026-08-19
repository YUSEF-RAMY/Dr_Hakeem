<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_user_can_register_and_auto_create_patient_profile(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'                  => 'Test Patient',
            'email'                 => 'patient@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role'                  => 'patient',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'patient_profile' => ['patient_code', 'settings'],
                    ],
                    'token',
                ],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'patient@example.com']);
        $this->assertDatabaseHas('patient_profiles', ['user_id' => $response->json('data.user.id')]);
    }

    public function test_patient_can_get_and_update_profile_settings(): void
    {
        $user = User::factory()->create();

        // Get Profile
        $profileResponse = $this->actingAs($user)->getJson('/api/v1/patient/profile');
        $profileResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        // Update Settings
        $updateResponse = $this->actingAs($user)->putJson('/api/v1/patient/settings', [
            'age'              => 35,
            'blood_group'      => 'A+',
            'skin_type'        => 'Type II',
            'conditions'       => ['Hypertension'],
            'active_allergies' => ['Penicillin'],
            'settings'         => [
                'notifications_enabled' => true,
                'dark_mode'             => true,
            ],
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.age', 35)
            ->assertJsonPath('data.blood_group', 'A+')
            ->assertJsonPath('data.skin_type', 'Type II');
    }
}
