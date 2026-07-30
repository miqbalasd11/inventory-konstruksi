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
        Schema::create('proyeks', function (Blueprint $table) {

            $table->id();

            $table->string('kode_proyek')->unique();

            $table->string('nama_proyek');

            $table->text('lokasi');

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai')->nullable();

            $table->enum('status', [
                'Aktif',
                'Selesai',
                'Pending',
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
