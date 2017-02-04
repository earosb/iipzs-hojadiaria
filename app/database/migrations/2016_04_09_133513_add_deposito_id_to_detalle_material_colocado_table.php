<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDepositoIdToDetalleMaterialColocadoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_material_colocado', function (Blueprint $table) {
            $table->integer('deposito_id')->unsigned()->nullable();
            $table->foreign('deposito_id')->references('id')->on('deposito');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_material_colocado', function (Blueprint $table) {
            $table->dropForeign('detalle_material_colocado_deposito_id_foreign');
            $table->dropColumn('deposito_id');
        });
    }

}
