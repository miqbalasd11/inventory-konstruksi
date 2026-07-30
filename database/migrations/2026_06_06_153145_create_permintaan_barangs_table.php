<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_barangs', function (Blueprint $table) {

            $table->id();

            $table->string('kode_permintaan')->unique();

            $table->date('tanggal');

            $table->foreignId('proyek_id')
                ->constrained('proyeks')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->cascadeOnDelete();

            $table->integer('qty');

            $table->text('keterangan')->nullable();

            $table->enum('status', [
                'Menunggu',
                'Disetujui',
                'Ditolak',
                'Selesai',
            ])->default('Menunggu');

            // Staff Lapangan yang mengajukan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Manager yang approve
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            $table->text('catatan_manager')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_barangs');
    }
};
