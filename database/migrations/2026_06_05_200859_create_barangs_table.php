<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {

            $table->id();

            $table->string('kode_barang')->unique();
            $table->string('nama_barang');

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            $table->foreignId('satuan_id')
                ->constrained('satuans')
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->nullOnDelete();

            $table->integer('stok')->default(0);

            $table->integer('stok_minimum')->default(0);

            $table->decimal('harga_beli', 15, 2)
                ->default(0);

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
