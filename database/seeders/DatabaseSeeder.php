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

        // 1. Primary Patient User (Matches Postman Collection Default Credentials)
        $patientUser = User::firstOrCreate(
            ['email' => 'ahmed.hakeem@example.com'],
            [
                'name'     => 'أحمد محمود',
                'password' => bcrypt('Password123!'),
            ]
        );
        $patientUser->assignRole('patient');

        PatientProfile::firstOrCreate(
            ['user_id' => $patientUser->id],
            [
                'patient_code'     => 'PAT-A8F2K1',
                'age'              => 32,
                'blood_group'      => 'A+',
                'skin_type'        => 'Type II',
                'conditions'       => ['Hypertension'],
                'active_allergies' => ['Penicillin'],
                'settings'         => [
                    'notifications_enabled' => true,
                    'dark_mode'             => false,
                    'language'              => 'ar',
                ],
            ]
        );

        // 2. Doctor User
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@skindiagnosis.com'],
            [
                'name'     => 'د. أحمد الحكيم',
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
                'name'     => 'على حسن',
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

        // 5. Seed Sample Diagnosis Scans for Patient 1
        Diagnosis::firstOrCreate(
            [
                'user_id'         => $patientUser->id,
                'image_path'      => 'diagnoses/sample_nevus.png',
            ],
            [
                'patient_id_code'   => 'PAT-A8F2K1',
                'predicted_class'   => SkinDiseaseClass::NV->value,
                'predicted_label'   => 'Melanocytic nevi',
                'confidence'        => 0.989399,
                'risk_level'        => RiskLevel::LOW->value,
                'inference_time_ms' => 141.29,
                'severity_analysis' => [
                    'risk_level'        => RiskLevel::LOW->value,
                    'risk_label_ar'     => RiskLevel::LOW->label(),
                    'badge_color'       => RiskLevel::LOW->badgeColor(),
                    'is_malignant'      => false,
                    'recommendation_ar' => 'النتيجة تشير إلى آفة حميدة غالباً (وحمات صبغية (شامة)). يُنصح بمراقبة أي تغيرات في الشكل أو اللون وتطبيق واقي الشمس بصورة منتظمة.',
                    'recommendation_en' => 'Low risk lesion detected (Melanocytic nevi). Routine monitoring and general skin protection are advised.',
                    'confidence_score'  => 0.989399,
                    'inference_time_ms' => 141.29,
                ],
                'tta_used'          => true,
                'raw_response'      => [
                    'success'           => true,
                    'filename'          => 'skin_lesion_1.png',
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
                ],
                'status'            => ScanStatus::COMPLETED->value,
            ]
        );

        Diagnosis::firstOrCreate(
            [
                'user_id'         => $patientUser->id,
                'image_path'      => 'diagnoses/sample_bcc.png',
            ],
            [
                'patient_id_code'   => 'PAT-A8F2K1',
                'predicted_class'   => SkinDiseaseClass::BCC->value,
                'predicted_label'   => 'Basal cell carcinoma',
                'confidence'        => 0.875000,
                'risk_level'        => RiskLevel::HIGH->value,
                'inference_time_ms' => 135.50,
                'severity_analysis' => [
                    'risk_level'        => RiskLevel::HIGH->value,
                    'risk_label_ar'     => RiskLevel::HIGH->label(),
                    'badge_color'       => RiskLevel::HIGH->badgeColor(),
                    'is_malignant'      => true,
                    'recommendation_ar' => 'تنبيه: تشير تحليلات الذكاء الاصطناعي إلى احتمال وجود آفة جلدية قد تكون خطيرة (سرطان الخلايا القاعدية). يُوصى بشدة بمراجعة طبيب أخصائي أمراض جلدية لإجراء فحص سريري وخزعة في أقرب وقت.',
                    'recommendation_en' => 'Warning: AI analysis suggests a potentially high-risk lesion (Basal cell carcinoma). Immediate consultation with a dermatologist for clinical evaluation is strongly recommended.',
                    'confidence_score'  => 0.875000,
                    'inference_time_ms' => 135.50,
                ],
                'tta_used'          => true,
                'raw_response'      => [
                    'success'           => true,
                    'filename'          => 'skin_lesion_2.png',
                    'inference_time_ms' => 135.50,
                    'predicted_class'   => 'bcc',
                    'predicted_label'   => 'Basal cell carcinoma',
                    'confidence'        => 0.875000,
                    'top_3'             => [
                        ['class' => 'bcc', 'label' => 'Basal cell carcinoma', 'confidence' => 0.875000],
                        ['class' => 'akiec', 'label' => 'Actinic keratoses', 'confidence' => 0.082000],
                        ['class' => 'bkl', 'label' => 'Benign keratosis-like lesions', 'confidence' => 0.043000],
                    ],
                    'tta_used'          => true,
                    'tta_views'         => 5,
                ],
                'status'            => ScanStatus::COMPLETED->value,
            ]
        );
    }
}
