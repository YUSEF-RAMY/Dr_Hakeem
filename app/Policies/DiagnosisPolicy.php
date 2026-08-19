<?php

namespace App\Policies;

use App\Models\Diagnosis;
use App\Models\User;

class DiagnosisPolicy
{
    /**
     * Determine whether the user can view the diagnosis.
     */
    public function view(User $user, Diagnosis $diagnosis): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('doctor')) {
            return true;
        }

        return $user->id === $diagnosis->user_id;
    }

    /**
     * Determine whether the user can delete the diagnosis.
     */
    public function delete(User $user, Diagnosis $diagnosis): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('doctor')) {
            return true;
        }

        return $user->id === $diagnosis->user_id;
    }
}
