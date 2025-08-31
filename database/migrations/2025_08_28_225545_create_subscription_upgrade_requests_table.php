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
        Schema::create('subscription_upgrade_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->decimal('unique_price', 15, 2)->nullable()->default(null);
            $table->unsignedBigInteger('months')->nullable()->default(1);
            $table->string('ref_key');
            $table->text('observation')->nullable()->default(null);
            $table->datetime('will_start_at')->nullable()->default(null);
            $table->datetime('validate_at')->nullable()->default(null);
            $table->datetime('locked_at')->nullable()->default(null);
            $table->datetime('will_closed_at')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->unsignedBigInteger('payment_id')->nullable()->default(null);
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
        Schema::dropIfExists('subscription_upgrade_requests');
    }
};
