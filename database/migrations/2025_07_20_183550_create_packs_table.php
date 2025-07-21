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
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->decimal('price', 15, 2)->nullable()->default(null);
            $table->string('discount')->nullable()->default(null);
            $table->json('privileges')->default(null)->nullable();
            $table->unsignedBigInteger('max_images')->nullable()->default(3);
            $table->unsignedBigInteger('max_assistants')->nullable()->default(1);
            $table->unsignedBigInteger('max_stats')->nullable()->default(3);
            $table->unsignedBigInteger('max_infos')->nullable()->default(3);
            $table->unsignedBigInteger('subscribed')->nullable()->default(0);
            $table->boolean('on_page')->default(false);
            $table->boolean('seen_by')->default(false);
            $table->boolean('notify_by_sms')->default(false);
            $table->boolean('notify_by_email')->default(false);
            $table->boolean('promoting')->default(false);
            $table->boolean('is_active')->default(false);
            $table->decimal('promo_price', 15, 2)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
