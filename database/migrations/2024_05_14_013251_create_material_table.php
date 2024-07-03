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
        Schema::create('material', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('codigo');
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('existencia');
            $table->date('fecha_caducidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
