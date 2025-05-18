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
        Schema::table('supirs', function (Blueprint $table) {
            //
            $table->enum('status_hadir', ['hadir', 'tidak hadir'])->default('hadir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supirs', function (Blueprint $table) {
            //
        });
    }
};
