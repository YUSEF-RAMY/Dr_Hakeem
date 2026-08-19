<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_code',
        'age',
        'blood_group',
        'skin_type',
        'conditions',
        'active_allergies',
        'settings',
    ];

    protected $casts = [
        'age'              => 'integer',
        'conditions'       => 'array',
        'active_allergies' => 'array',
        'settings'         => 'array',
    ];

    /**
     * Get the user that owns the patient profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
