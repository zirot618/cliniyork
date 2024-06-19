<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fechaHora');
            $table->string('motivo');
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('paciente_id');
            $table->timestamps();

            
            $table->foreign('medico_id')->references('id')->on('medico');
            $table->foreign('paciente_id')->references('id')->on('paciente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
