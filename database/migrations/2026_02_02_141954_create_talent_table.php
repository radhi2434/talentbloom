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
        Schema::create('talent', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            $table->string('title');
            $table->string('category')->nullable();
            $table->string('level')->nullable();
            $table->date('achieved_at')->nullable();
            $table->text('description')->nullable();

            $table->string('proof_path')->nullable(); // file path

            $table->timestamps();

            $table->index(['student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent');
    }
};
