<?php

namespace App\Models;

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
        'image_path',
        'predicted_class',
        'predicted_label',
        'confidence',
        'inference_time_ms',
        'tta_used',
        'raw_response',
        'status',
        'error_message',
    ];

    protected $casts = [
        'predicted_class'   => SkinDiseaseClass::class,
        'status'            => ScanStatus::class,
        'confidence'        => 'float',
        'inference_time_ms' => 'float',
        'tta_used'          => 'boolean',
        'raw_response'      => 'array',
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
}
