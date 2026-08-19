<?php

namespace App\Enums;

enum RiskLevel: string
{
    case LOW      = 'low';
    case MODERATE = 'moderate';
    case HIGH     = 'high';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::LOW      => 'منخفض الخطورة',
            self::MODERATE => 'متوسط الخطورة',
            self::HIGH     => 'عالي الخطورة',
            self::CRITICAL => 'حرج جدًا (يتطلب تدخل فوري)',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::LOW      => 'green',
            self::MODERATE => 'yellow',
            self::HIGH     => 'orange',
            self::CRITICAL => 'red',
        };
    }

    /**
     * Compute risk level based on disease class and prediction confidence score.
     */
    public static function compute(?SkinDiseaseClass $diseaseClass, ?float $confidence): self
    {
        if (!$diseaseClass || $confidence === null) {
            return self::LOW;
        }

        if ($diseaseClass->isMalignant()) {
            if ($confidence >= 0.80) {
                return self::CRITICAL;
            }
            return self::HIGH;
        }

        if ($confidence >= 0.85) {
            return self::LOW;
        }

        return self::MODERATE;
    }
}
