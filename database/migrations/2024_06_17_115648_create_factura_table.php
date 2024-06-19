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
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->float('monto');
            $table->unsignedBigInteger('cita_id');
            $table->unsignedBigInteger('paciente_id');

            $table->foreign('cita_id')->references('id')->on('Cita');
            $table->foreign('paciente_id')->references('id')->on('Paciente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
