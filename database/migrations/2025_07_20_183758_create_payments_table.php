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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('email')->nullable()->default(null);
            $table->string('contacts')->nullable()->default(null);
            $table->text('observation')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->unsignedBigInteger('pack_id')->nullable()->default(null);
            $table->foreign('pack_id')->references('id')->on('packs')->nullOnDelete();
            $table->date('payed_at')->nullable()->default(null);
            $table->decimal('amount', 15, 2)->nullable()->default(null);
            $table->string('payment_status')->nullable()->default('En cours');
            $table->boolean('validate')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
