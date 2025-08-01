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
        Schema::disableForeignKeyConstraints();
        Schema::create('assistant_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistant_id');
            $table->foreign('assistant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('director_id');
            $table->foreign('director_id')->references('id')->on('users')->cascadeOnDelete();
            $table->json('privileges')->nullable()->default(null);
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('token');
            $table->string('status')->default('En attente');
            $table->datetime('delay');
            $table->boolean('is_active')->default(false);
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
