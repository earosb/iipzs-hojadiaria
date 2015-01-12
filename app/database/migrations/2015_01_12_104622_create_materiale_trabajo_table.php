<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateMaterialeTrabajoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajos_materiales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_material')->unsigned()->index();
			$table->foreign('id_material')->references('id')->on('materials')->onDelete('cascade');
			$table->integer('id_trabajo')->unsigned()->index();
			$table->foreign('id_trabajo')->references('id')->on('trabajos')->onDelete('cascade');
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
		Schema::drop('trabajos_materiales');
	}

}
