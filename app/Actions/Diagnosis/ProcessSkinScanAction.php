<?php

namespace App\Actions\Diagnosis;

use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class ProcessSkinScanAction
{
    public function __construct(
        protected ProcessScanAction $processScanAction
    ) {}

    public function execute(User $user, UploadedFile $image, bool $tta = true): Diagnosis
    {
        return $this->processScanAction->execute($user, $image, $tta);
    }
}
