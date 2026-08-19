<?php

namespace App\Enums;

enum ScanStatus: string
{
    case PENDING   = 'pending';
    case COMPLETED = 'completed';
    case FAILED    = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING   => 'قيد المعالجة',
            self::COMPLETED => 'مكتمل',
            self::FAILED    => 'فشل التشخيص',
        };
    }
}
