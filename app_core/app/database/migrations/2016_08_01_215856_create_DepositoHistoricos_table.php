<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepositoHistoricosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposito_historico', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('tipo');
            $table->integer('cantidad');
            $table->integer('saldo');

            $table->integer('deposito_id')->unsigned()->nullable();
            $table->foreign('deposito_id')->references('id')->on('deposito');

            $table->integer('carga_id')->unsigned()->nullable();
            $table->foreign('carga_id')->references('id')->on('carga');

            $table->integer('detalle_material_colocado_id')->unsigned()->nullable();
            $table->foreign('detalle_material_colocado_id')->references('id')->on('detalle_material_colocado');

            $table->integer('detalle_material_retirado_id')->unsigned()->nullable();
            $table->foreign('detalle_material_retirado_id')->references('id')->on('detalle_material_retirado');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deposito_historico');
    }

}
