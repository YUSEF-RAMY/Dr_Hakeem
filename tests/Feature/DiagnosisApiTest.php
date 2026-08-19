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

    public function test_user_can_process_skin_scan_diagnosis(): void
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

        $response = $this->actingAs($user)->postJson('/api/v1/diagnoses/process', [
            'file' => $file,
            'tta'  => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.predicted_class', 'nv')
            ->assertJsonPath('data.risk_level', 'low')
            ->assertJsonPath('data.status', 'completed');
    }

    public function test_user_can_fetch_diagnosis_history(): void
    {
        $user = User::factory()->create();
        Diagnosis::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/diagnoses/history');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data.data');
    }

    public function test_can_fetch_dashboard_stats(): void
    {
        $user = User::factory()->create();
        Diagnosis::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/dashboard/stats');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'total_scans',
                    'completed_scans',
                    'failed_scans',
                    'high_risk_scans',
                    'growth_rate',
                    'accuracy_metrics',
                    'disease_distribution',
                    'recent_scans',
                ],
            ]);
    }
}
