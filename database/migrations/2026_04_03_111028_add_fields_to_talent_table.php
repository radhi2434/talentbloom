<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('talent', function (Blueprint $table) {
            $table->string('award')->nullable();
            $table->integer('points')->default(0);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('talent', function (Blueprint $table) {
            //
        });
    }
};
