<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateDetalleMaterialColocadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_material_colocado', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cantidad');
			$table->boolean('reempleo');
			
			$table->integer('hoja_diaria_id')->unsigned();
			$table->foreign('hoja_diaria_id')->references('id')->on('hoja_diaria');
			
			$table->integer('material_id')->unsigned();
			$table->foreign('material_id')->references('id')->on('material');

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
		Schema::drop('detalle_material_colocado');
	}

}
