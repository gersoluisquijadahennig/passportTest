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
        Schema::create('BIBLIOTECA_VIRTUAL.USUARIO_PANEL', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->nullable();
            $table->string('clave')->nullable();
            $table->integer('personas_id')->nullable();
            $table->integer('perfil_id')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->timestamp('fecha_ingreso')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('usuario_id_mod')->nullable();
            $table->integer('establecimiento_id')->nullable();
            $table->integer('estab_unid_func_id')->nullable();
            $table->integer('unidad_funcional_origen_id')->nullable();
            $table->boolean('proyecto_predeterminado')->default(false);
            $table->string('alias')->nullable();
            $table->string('run')->nullable();
            $table->timestamp('ultimo_acceso')->nullable();
            $table->boolean('habilita_depuracion')->default(false);
            $table->timestamp('fecha_clave')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BIBLIOTECA_VIRTUAL.USUARIO_PANEL');
    }
};