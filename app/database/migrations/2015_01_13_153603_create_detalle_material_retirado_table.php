<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateDetalleMaterialRetiradoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_material_retirado', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cantidad');
			
			$table->integer('hoja_diaria_id')->unsigned()->index();
			$table->foreign('hoja_diaria_id')->references('id')->on('hoja_diaria')
				->onDelete('cascade');
			
			$table->integer('material_retirado_id')->unsigned()->index();
			$table->foreign('material_retirado_id')->references('id')->on('material_retirado')
				->onDelete('cascade');
			
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
		Schema::drop('detalle_material_retirado');
	}

}
