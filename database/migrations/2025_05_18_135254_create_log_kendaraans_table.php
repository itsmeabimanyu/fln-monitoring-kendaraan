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
        Schema::create('log_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained()->onDelete('cascade');
            $table->foreignId('supir_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('penumpang')->nullable();
            $table->enum('status', ['standby', 'pergi', 'perbaikan'])->default('standby');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_kendaraans');
    }
};
