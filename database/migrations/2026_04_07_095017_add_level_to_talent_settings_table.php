<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talent_settings', function (Blueprint $table) {
            $table->string('level')->nullable()->after('award');
        });
    }

    public function down(): void
    {
        Schema::table('talent_settings', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
