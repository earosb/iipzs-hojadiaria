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
			$table->decimal('cantidad', 10, 2);
            $table->boolean('reempleo');
			
			$table->integer('hoja_diaria_id')->unsigned();
			$table->foreign('hoja_diaria_id')->references('id')->on('hoja_diaria');
			
			$table->integer('material_retirado_id')->unsigned();
			$table->foreign('material_retirado_id')->references('id')->on('material_retirado');
			
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
