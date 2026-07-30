<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_po')->unique();

            // berasal dari MR yang sudah approved
            $table->foreignId('material_request_id')
                ->constrained('material_requests')
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->nullOnDelete();

            $table->date('tanggal_po');

            $table->decimal('total', 15, 2)
                ->default(0);

            $table->enum('status', [
                'Draft',
                'Dipesan',
                'Diterima',
                'Dibatalkan'
            ])->default('Draft');

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};