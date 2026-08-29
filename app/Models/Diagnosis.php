<?php

namespace App\Models;

use App\Enums\RiskLevel;
use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id_code',
        'image_path',
        'heatmap_path',
        'predicted_class',
        'predicted_label',
        'explained_class',
        'explained_label',
        'explained_class_confidence',
        'confidence',
        'risk_level',
        'inference_time_ms',
        'severity_analysis',
        'tta_used',
        'alpha',
        'raw_response',
        'status',
        'error_message',
    ];

    protected $casts = [
        'predicted_class'            => SkinDiseaseClass::class,
        'risk_level'                 => RiskLevel::class,
        'status'                     => ScanStatus::class,
        'confidence'                 => 'float',
        'explained_class_confidence' => 'float',
        'alpha'                      => 'float',
        'inference_time_ms'          => 'float',
        'tta_used'                   => 'boolean',
        'severity_analysis'          => 'array',
        'raw_response'               => 'array',
    ];

    /**
     * Get the user that owns the skin diagnosis.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full HTTP URL of uploaded skin image.
     */
    public function getImageUrlAttribute(): string
    {
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Get full HTTP URL of generated heatmap overlay image.
     */
    public function getHeatmapUrlAttribute(): ?string
    {
        if (!$this->heatmap_path) {
            return null;
        }

        if (filter_var($this->heatmap_path, FILTER_VALIDATE_URL)) {
            return $this->heatmap_path;
        }

        return Storage::disk('public')->url($this->heatmap_path);
    }
}
