<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_request_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('material_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('qty');

            $table->string('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_request_details');
    }
};