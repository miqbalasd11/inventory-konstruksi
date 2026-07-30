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
        Schema::table('material_requests', function (Blueprint $table) {

            $table->dropForeign(['proyek_id']);

            $table->dropColumn('proyek_id');
        });
    }

    public function down(): void
    {
        Schema::table('material_requests', function (Blueprint $table) {

            $table->foreignId('proyek_id')
                ->nullable()
                ->constrained();
        });
    }
};
