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
        Schema::create('school_best_pupils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('pupil_name')->nullable()->default(null);
            $table->string('exam')->nullable()->default(null);
            $table->boolean('hidden')->default(false);
            $table->string('image_path')->nullable()->default(null);
            $table->json('details')->nullable()->default(null);
            $table->json('ranks')->nullable()->default(null);
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('mention')->nullable()->default(null);
            $table->decimal('average', 5, 2)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_best_pupils');
    }
};
