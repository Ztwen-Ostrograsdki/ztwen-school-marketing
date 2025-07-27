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
        Schema::create('assistant_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('used_count')->nullable()->default(null);
            $table->json('only_for')->nullable()->default(null);
            $table->json('privileges')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->unsignedBigInteger('max_usesable')->default(1);
            $table->string('token');
            $table->datetime('delay');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistant_tokens');
    }
};
