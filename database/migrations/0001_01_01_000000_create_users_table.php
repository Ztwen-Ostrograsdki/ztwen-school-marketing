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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->uuid('uuid')->unique();
            $table->string('pseudo')->nullable()->default(null);
            $table->string('identifiant')->unique();
            $table->string('auth_token')->nullable()->default(null);
            $table->string('contacts')->nullable()->default(null);
            $table->string('FEDAPAY_ID')->nullable()->default(null);
            $table->string('adress')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->string('gender')->nullable()->default(null);
            $table->string('firstname')->nullable()->default(null);
            $table->string('lastname')->nullable()->default(null);
            $table->string('profil_photo')->nullable()->default(null);
            $table->string('password_reset_key')->nullable()->default(null);
            $table->string('email_verify_key')->nullable()->default(null);
            $table->boolean('blocked')->default(false);
            $table->datetime('blocked_at')->nullable()->default(null);
            $table->string('blocked_because')->nullable()->default(null);
            $table->unsignedBigInteger('wrong_password_tried')->nullable()->default(null);
            $table->unsignedBigInteger('assistant_of')->nullable()->default(null);
            $table->foreign('assistant_of')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
