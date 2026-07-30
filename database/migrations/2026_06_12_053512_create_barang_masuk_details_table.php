<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuk_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('barang_masuk_id')
                ->constrained('barang_masuks')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->cascadeOnDelete();

            $table->integer('qty');

            $table->decimal(
                'harga_beli',
                15,
                2
            );

            $table->decimal(
                'subtotal',
                15,
                2
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_details');
    }
};
