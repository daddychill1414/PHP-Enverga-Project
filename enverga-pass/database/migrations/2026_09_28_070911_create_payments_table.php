<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->decimal('amount', 8, 2);
            $table->string('payment_method')->default('GCash'); // GCash, Maya, Over-The-Counter, Cashier
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('completed');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
