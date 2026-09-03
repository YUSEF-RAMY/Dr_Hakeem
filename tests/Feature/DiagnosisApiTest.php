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
            '*drhakeem*' => Http::response([
                'success'           => true,
                'filename'          => 'skin_sample.png',
                'content_type'      => 'image/png',
                'inference_time_ms' => 141.29,
                'predicted_class'   => 'nv',
                'predicted_label'   => 'Melanocytic nevi',
                'confidence'        => 0.989399,
                'top_predictions'   => [
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
            ->assertJsonPath('data.status', 'completed')
            ->assertJsonPath('data.top_predictions.0.class', 'nv')
            ->assertJsonPath('data.top_predictions.0.confidence', 98.94)
            ->assertJsonPath('data.top_predictions.0.confidence_percentage', '98.94%')
            ->assertJsonPath('data.confidence_percentage', '98.94%')
            ->assertJsonMissingPath('data.heatmap_url')
            ->assertJsonMissingPath('data.overlay_url')
            ->assertJsonMissingPath('data.explained_class')
            ->assertJsonMissingPath('data.alpha');
    }

    public function test_user_can_process_explain_heatmap_diagnosis(): void
    {
        // 1x1 dummy PNG in base64
        $dummyBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        Http::fake([
            '*drhakeem*' => Http::response([
                'success'                    => true,
                'filename'                   => 'skin_lesion_1.png',
                'predicted_class'            => 'nv',
                'predicted_label'            => 'Melanocytic nevi',
                'confidence'                 => 0.989888,
                'explained_class'            => 'nv',
                'explained_label'            => 'Melanocytic nevi',
                'explained_class_confidence' => 0.989888,
                'top_predictions'            => [
                    ['class' => 'nv', 'label' => 'Melanocytic nevi', 'confidence' => 0.989888],
                    ['class' => 'mel', 'label' => 'Melanoma', 'confidence' => 0.003408],
                    ['class' => 'bcc', 'label' => 'Basal cell carcinoma', 'confidence' => 0.002603],
                ],
                'heatmap_base64'             => $dummyBase64,
                'overlay_base64'             => $dummyBase64,
            ], 200),
        ]);

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('skin_lesion.png', 500, 500);

        $response = $this->actingAs($user)->postJson('/api/v1/diagnoses/explain', [
            'file'  => $file,
            'alpha' => 0.45,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.predicted_class', 'nv')
            ->assertJsonPath('data.explained_class', 'nv')
            ->assertJsonPath('data.alpha', 0.45)
            ->assertJsonPath('data.status', 'completed')
            ->assertJsonPath('data.top_predictions.0.confidence', 98.99)
            ->assertJsonPath('data.top_predictions.0.confidence_percentage', '98.99%');

        $heatmapUrl = $response->json('data.heatmap_url');
        $this->assertNotNull($heatmapUrl);

        $overlayUrl = $response->json('data.overlay_url');
        $this->assertNotNull($overlayUrl);
    }

    public function test_user_can_fetch_diagnosis_history(): void
    {
        $user = User::factory()->create();
        Diagnosis::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/diagnoses/history');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data.data')
            ->assertJsonPath('data.data.0.raw_response.confidence', 95.43)
            ->assertJsonPath('data.data.0.raw_response.confidence_percentage', '95.43%')
            ->assertJsonPath('data.data.0.confidence', 95.43)
            ->assertJsonPath('data.data.0.confidence_percentage', '95.43%');
    }

    public function test_user_can_fetch_single_diagnosis_details(): void
    {
        $user = User::factory()->create();
        $diagnosis = Diagnosis::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/diagnoses/' . $diagnosis->id);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $diagnosis->id)
            ->assertJsonPath('data.confidence', 95.43);
    }

    public function test_fetching_missing_diagnosis_returns_clean_404(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/diagnoses/999999');

        $response->assertStatus(404)
            ->assertJsonPath('success', false)
            ->assertJsonMissingPath('data');
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
