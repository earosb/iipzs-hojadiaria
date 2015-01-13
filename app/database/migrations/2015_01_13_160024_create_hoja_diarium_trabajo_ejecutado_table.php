<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateHojaDiariumTrabajoEjecutadoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hoja_diaria_trabajo_ejecutado', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_hoja_diaria')->unsigned()->index();
			$table->foreign('id_hoja_diaria')->references('id')->on('hoja_diaria')->onDelete('cascade');
			$table->integer('id_trabajo_ejecutado')->unsigned()->index();
			$table->foreign('id_trabajo_ejecutado')->references('id')->on('trabajo_ejecutado')->onDelete('cascade');
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
		Schema::drop('hoja_diaria_trabajo_ejecutado');
	}

}
