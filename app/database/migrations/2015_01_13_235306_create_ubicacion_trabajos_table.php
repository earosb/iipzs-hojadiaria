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
			
			$table->integer('trabajo_ejecutado_id')->unsigned();
			$table->foreign('trabajo_ejecutado_id')->references('id')->on('trabajo_ejecutado')
				->onDelete('cascade')->onUpdate('cascade');

			$table->integer('block_id')->unsigned()->nullable();
			$table->foreign('block_id')->references('id')->on('block')
				->onDelete('cascade')->onUpdate('cascade');
			
			$table->integer('desviador_id')->unsigned()->nullable();
			$table->foreign('desviador_id')->references('id')->on('desviador')
				->onDelete('cascade')->onUpdate('cascade');
			
			$table->integer('desvio_id')->unsigned()->nullable();
			$table->foreign('desvio_id')->references('id')->on('desvio')
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
