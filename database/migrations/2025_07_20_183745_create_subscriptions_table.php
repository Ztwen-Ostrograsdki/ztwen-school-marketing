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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->decimal('unique_price', 15, 2)->nullable()->default(null);
            $table->unsignedBigInteger('months')->nullable()->default(1);
            $table->string('free_days')->nullable()->default(null);
            $table->text('observation')->nullable()->default(null);
            $table->datetime('validate_at')->nullable()->default(null);
            $table->datetime('will_closed_at')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('pack_id')->constrained('packs')->cascadeOnDelete();
            
            $table->unsignedBigInteger('payment_id')->nullable()->default(null);
            $table->json('privileges')->default(null)->nullable();
            $table->unsignedBigInteger('max_images')->nullable()->default(3);
            $table->unsignedBigInteger('max_assistants')->nullable()->default(1);
            $table->unsignedBigInteger('max_stats')->nullable()->default(3);
            $table->unsignedBigInteger('max_infos')->nullable()->default(3);
            $table->boolean('on_page')->default(false);
            $table->boolean('seen_by')->default(false);
            $table->boolean('notify_by_sms')->default(false);
            $table->boolean('notify_by_email')->default(false);
            $table->string('discount')->nullable()->default(null);
            $table->boolean('promoting')->default(false);
            $table->decimal('amount', 15, 2)->nullable()->default(null);
            $table->string('payment_status')->nullable()->default('En cours');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
