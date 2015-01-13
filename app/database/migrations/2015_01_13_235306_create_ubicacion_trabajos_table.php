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
		Schema::create('ubicacion_trabajo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('km_inicio');
			$table->integer('km_termino');
			
			$table->integer('id_trabajo_ejecutado')->unsigned();
			$table->foreign('id_trabajo_ejecutado')->references('id')->on('trabajo_ejecutado')
				->onDelete('cascade')->onUpdate('cascade');

			$table->integer('id_block')->unsigned()->nullable();
			$table->foreign('id_block')->references('id')->on('block')
				->onDelete('cascade')->onUpdate('cascade');
			
			$table->integer('id_desviador')->unsigned()->nullable();
			$table->foreign('id_desviador')->references('id')->on('desviador')
				->onDelete('cascade')->onUpdate('cascade');
			
			$table->integer('id_desvio')->unsigned()->nullable();
			$table->foreign('id_desvio')->references('id')->on('desvio')
				->onDelete('cascade')->onUpdate('cascade');

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
		Schema::drop('ubicacion_trabajo');
	}

}
