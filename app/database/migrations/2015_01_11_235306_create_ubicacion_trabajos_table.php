<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUbicacionTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ubicacion_trabajos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('km_inicio');
			$table->integer('km_termino');
			$table->integer('id_trabajo')->unsigned();
			$table->foreign('id_trabajo')->references('id')->on('trabajos');

			$table->integer('id_block')->unsigned();
			$table->foreign('id_block')->references('id')->on('blocks');
			
			$table->integer('id_desviador')->unsigned();
			$table->foreign('id_desviador')->references('id')->on('desviadors');
			
			$table->integer('id_desvio')->unsigned();
			$table->foreign('id_desvio')->references('id')->on('desvios');
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
		Schema::drop('ubicacion_trabajos');
	}

}
