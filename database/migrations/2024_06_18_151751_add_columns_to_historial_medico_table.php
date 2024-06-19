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
        Schema::table('historial_medico', function (Blueprint $table) {
            $table->text('antecedentes_medicos')->nullable();
            $table->text('historial_medicamentos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_medico', function (Blueprint $table) {
            $table->dropColumn('antecedentes_medicos');
            $table->dropColumn('historial_medicamentos');
        });
    }
};
