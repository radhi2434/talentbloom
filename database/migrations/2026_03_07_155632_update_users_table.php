<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Add gender column
            $table->enum('gender', ['male', 'female'])
                  ->nullable()
                  ->after('role');

            // Add form column for students
            $table->integer('form')
                  ->nullable()
                  ->after('gender');

            // Rename class to class_name
            $table->renameColumn('class', 'class_name');

            // Add date joined (student school registration date)
            $table->date('date_joined')
                  ->nullable()
                  ->after('class_name');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Remove added columns
            $table->dropColumn('gender');
            $table->dropColumn('form');
            $table->dropColumn('date_joined');

            // Rename class_name back to class
            $table->renameColumn('class_name', 'class');

        });
    }
};
