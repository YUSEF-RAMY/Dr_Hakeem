<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->string('heatmap_path')->nullable()->after('image_path');
            $table->string('explained_class')->nullable()->after('predicted_label');
            $table->string('explained_label')->nullable()->after('explained_class');
            $table->decimal('explained_class_confidence', 8, 6)->nullable()->after('explained_label');
            $table->decimal('alpha', 4, 2)->default(0.45)->nullable()->after('tta_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->dropColumn([
                'heatmap_path',
                'explained_class',
                'explained_label',
                'explained_class_confidence',
                'alpha',
            ]);
        });
    }
};
