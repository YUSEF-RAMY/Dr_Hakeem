<?php

namespace App\Enums;

enum SkinDiseaseClass: string
{
    case AKIEC = 'akiec';
    case BCC   = 'bcc';
    case BKL   = 'bkl';
    case NV    = 'nv';
    case MEL   = 'mel';

    /**
     * Get full English label for disease code.
     */
    public function label(): string
    {
        return match ($this) {
            self::AKIEC => 'Actinic Keratoses and Intraepithelial Carcinoma',
            self::BCC   => 'Basal Cell Carcinoma',
            self::BKL   => 'Benign Keratosis-like Lesions',
            self::NV    => 'Melanocytic Nevi',
            self::MEL   => 'Melanoma',
        };
    }

    /**
     * Get Arabic label for disease code.
     */
    public function labelAr(): string
    {
        return match ($this) {
            self::AKIEC => 'التقان السعفي وسرطان الخلايا الحرشوفية داخل البشرة',
            self::BCC   => 'سرطان الخلايا القاعدية',
            self::BKL   => 'آفات التقرن الحميدة',
            self::NV    => 'وحمات صبغية (شامة)',
            self::MEL   => 'ورم قتامي (ميلانوما)',
        };
    }

    /**
     * Determine if disease class is considered malignant/severe.
     */
    public function isMalignant(): bool
    {
        return match ($this) {
            self::AKIEC, self::BCC, self::MEL => true,
            self::BKL, self::NV               => false,
        };
    }

    /**
     * Try to create Enum from case-insensitive raw string.
     */
    public static function tryFromRaw(?string $value): ?self
    {
        if (empty($value)) {
            return null;
        }

        $normalized = strtolower(trim($value));

        foreach (self::cases() as $case) {
            if ($case->value === $normalized) {
                return $case;
            }
        }

        return null;
    }
}
