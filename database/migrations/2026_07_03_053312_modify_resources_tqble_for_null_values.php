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
         Schema::table('resources', function ($table) {
            $table->string('banner', 255)->nullable()->change();
            $table->string('authors', 255)->nullable()->change();
            $table->string('categories', 255)->nullable()->change();
            $table->string('topics', 255)->nullable()->change();
            $table->string('activities', 255)->nullable()->change();
            $table->string('opportunities', 255)->nullable()->change();
            $table->string('regions', 255)->nullable()->change();
            $table->string('language', 255)->nullable()->change();
            $table->string('content', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function ($table) {
            $table->string('banner', 255)->change();
            $table->string('authors', 255)->change();
            $table->string('categories', 255)->change();
            $table->string('topics', 255)->change();
            $table->string('activities', 255)->change();
            $table->string('opportunities', 255)->change();
            $table->string('regions', 255)->change();
            $table->string('language', 255)->change();
            $table->string('content', 255)->change();
        });
    }
};
