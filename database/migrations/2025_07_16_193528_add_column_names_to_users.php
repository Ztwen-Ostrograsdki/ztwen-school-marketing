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
        Schema::table('users', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
