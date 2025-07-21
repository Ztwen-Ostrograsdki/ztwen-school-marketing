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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('likes')->nullable()->default(2);
            $table->boolean('is_active')->default(true);
            $table->string('name')->nullable()->default(null);
            $table->string('contacts')->nullable()->default(null);
            $table->string('simple_name')->nullable()->default(null);
            $table->string('level')->nullable()->default(null);
            $table->string('slug')->unique();
            $table->string('system')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('quotes')->nullable()->default(null);
            $table->string('capacity')->nullable()->default(null);
            $table->json('objectives')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->text('observation')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
