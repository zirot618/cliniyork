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
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historial_medico_id');
            $table->unsignedBigInteger('medico_id');
            $table->string('descripcion');
            $table->string('tratamiento');
            $table->string('observaciones');

            $table->foreign('historial_medico_id')->references('id')->on('historial_medico');
            $table->foreign('medico_id')->references('id')->on('medico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostico');
    }
};
