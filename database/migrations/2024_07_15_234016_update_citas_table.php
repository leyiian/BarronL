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
        Schema::table('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_medicamento')->nullable();

            $table->foreign('id_medicamento')->references('id')->on('medicamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['id_medicamento']);
            $table->dropColumn('id_medicamento');
        });
    }
};
