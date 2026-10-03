<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('student_id')->unique();
            $table->string('student_name');
            $table->string('department');
            $table->decimal('tuition_balance', 10, 2)->default(0.00);
            $table->boolean('is_cleared')->default(true);
            $table->string('cleared_semester')->default('1st Semester 2026-2027');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_clearances');
    }
};
