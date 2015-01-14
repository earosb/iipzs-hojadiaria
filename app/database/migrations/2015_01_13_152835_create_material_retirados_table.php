<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateMaterialRetiradosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material_retirado', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cantidad');

			$table->integer('tipo_material_retirado_id')->unsigned();
			$table->foreign('tipo_material_retirado_id')->references('id')
				->on('tipo_material_retirado');

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
		Schema::drop('material_retirado');
	}

}
