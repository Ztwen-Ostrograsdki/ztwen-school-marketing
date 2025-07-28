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
        Schema::create('assistant_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistant_id')->nullable()->default(null);
            $table->json('privileges')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('token');
            $table->string('status')->default('En attente');
            $table->datetime('delay');
            $table->datetime('approved_at')->nullable()->default(null);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistant_requests');
    }
};
