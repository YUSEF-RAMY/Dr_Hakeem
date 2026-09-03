<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_login_with_invalid_credentials_returns_401_json(): void
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'user@example.com',
            'password' => 'WrongPassword!',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('success', false)
            ->assertJsonMissingPath('data');
    }

    public function test_validation_error_returns_422_with_errors(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'     => '',
            'email'    => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonStructure(['errors' => ['email']]);
    }

    public function test_unauthenticated_access_returns_401_json(): void
    {
        $response = $this->getJson('/api/v1/diagnoses/history');

        $response->assertStatus(401)
            ->assertJsonPath('success', false)
            ->assertJsonMissingPath('data');
    }

    public function test_missing_diagnosis_returns_404_json(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/diagnoses/999999');

        $response->assertStatus(404)
            ->assertJsonPath('success', false)
            ->assertJsonMissingPath('data');
    }

    public function test_ai_service_failure_in_process_returns_503_json(): void
    {
        Http::fake([
            '*drhakeem*' => Http::response([], 502),
        ]);

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('skin_lesion.jpg', 500, 500);

        $response = $this->actingAs($user)->postJson('/api/v1/diagnoses/process', [
            'file' => $file,
            'tta'  => true,
        ]);

        $response->assertStatus(503)
            ->assertJsonPath('success', false);
    }
}
