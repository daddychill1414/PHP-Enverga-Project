<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location')->default('MSEUF Gymnasium / Main Campus');
            $table->string('organizer')->default('MSEUF Supreme Student Council');
            $table->string('category')->default('University Event');
            $table->dateTime('event_date');
            $table->string('banner_image')->nullable();
            $table->integer('total_capacity')->default(500);
            $table->boolean('requires_tuition_clearance')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
