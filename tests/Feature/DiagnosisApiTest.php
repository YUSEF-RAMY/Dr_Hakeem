<?php

namespace Tests\Feature;

use App\Models\Diagnosis;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DiagnosisApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        Storage::fake('public');
    }

    public function test_user_can_upload_skin_image_and_get_ai_diagnosis(): void
    {
        Http::fake([
            'https://drhakeemapi-production.up.railway.app/predict*' => Http::response([
                'success'           => true,
                'filename'          => 'skin_sample.png',
                'content_type'      => 'image/png',
                'inference_time_ms' => 141.29,
                'predicted_class'   => 'nv',
                'predicted_label'   => 'Melanocytic nevi',
                'confidence'        => 0.989399,
                'top_3'             => [
                    ['class' => 'nv', 'label' => 'Melanocytic nevi', 'confidence' => 0.989399],
                    ['class' => 'mel', 'label' => 'Melanoma', 'confidence' => 0.003657],
                    ['class' => 'bcc', 'label' => 'Basal cell carcinoma', 'confidence' => 0.002652],
                ],
                'tta_used'          => true,
                'tta_views'         => 5,
            ], 200),
        ]);

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('skin_lesion.jpg', 600, 600);

        $response = $this->actingAs($user)->postJson('/api/v1/scans', [
            'file' => $file,
            'tta'  => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.predicted_class', 'nv')
            ->assertJsonPath('data.predicted_label', 'Melanocytic nevi')
            ->assertJsonPath('data.confidence', 0.989399)
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('diagnoses', [
            'user_id'         => $user->id,
            'predicted_class' => 'nv',
            'status'          => 'completed',
        ]);
    }

    public function test_user_can_list_their_diagnoses(): void
    {
        $user = User::factory()->create();
        Diagnosis::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/scans');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data.data');
    }

    public function test_user_can_view_single_diagnosis_details(): void
    {
        $user = User::factory()->create();
        $diagnosis = Diagnosis::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/scans/' . $diagnosis->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $diagnosis->id);
    }

    public function test_user_cannot_view_another_users_diagnosis(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $diagnosis = Diagnosis::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->getJson('/api/v1/scans/' . $diagnosis->id);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_diagnosis(): void
    {
        $user = User::factory()->create();
        $diagnosis = Diagnosis::factory()->create([
            'user_id'    => $user->id,
            'image_path' => 'diagnoses/test.jpg',
        ]);

        $response = $this->actingAs($user)->deleteJson('/api/v1/scans/' . $diagnosis->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('diagnoses', ['id' => $diagnosis->id]);
    }

    public function test_can_fetch_ai_model_info(): void
    {
        Http::fake([
            'https://drhakeemapi-production.up.railway.app/info' => Http::response([
                'model'   => 'Skin-Disease-ResNet50',
                'version' => '1.0.0',
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/ai/info');

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'online');
    }
}
