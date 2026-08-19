<?php

namespace Database\Factories;

use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    protected $model = Diagnosis::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'image_path'        => 'diagnoses/sample_' . $this->faker->uuid() . '.png',
            'predicted_class'   => SkinDiseaseClass::NV->value,
            'predicted_label'   => 'Melanocytic nevi',
            'confidence'        => 0.954321,
            'inference_time_ms' => 120.50,
            'tta_used'          => true,
            'raw_response'      => [
                'success'         => true,
                'predicted_class' => 'nv',
                'confidence'      => 0.954321,
            ],
            'status'            => ScanStatus::COMPLETED->value,
        ];
    }
}
