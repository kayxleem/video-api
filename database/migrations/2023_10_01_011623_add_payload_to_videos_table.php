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
        Schema::table('videos', function (Blueprint $table) {
            if (! Schema::hasColumn('videos', 'payload')) {
                $table->json('payload')->nullable();
            }
            if (! Schema::hasColumn('videos', 'segments')) {
                $table->json('segments')->nullable();
            }
            if (! Schema::hasColumn('videos', 'language')) {
                $table->string('language')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            //
        });
    }
};
