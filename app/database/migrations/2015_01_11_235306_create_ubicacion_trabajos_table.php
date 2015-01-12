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
			
			$table->integer('id_trabajo')
				->unsigned();
			$table->foreign('id_trabajo')
				->references('id')->on('trabajos')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->integer('id_block')
				->unsigned()
				->nullable();
			$table->foreign('id_block')
				->references('id')->on('blocks')
				->onDelete('cascade')
				->onUpdate('cascade');
			
			$table->integer('id_desviador')
				->unsigned()
				->nullable();
			$table->foreign('id_desviador')
				->references('id')->on('desviadors')
				->onDelete('cascade')
				->onUpdate('cascade');
			
			$table->integer('id_desvio')
				->unsigned()
				->nullable();
			$table->foreign('id_desvio')
				->references('id')->on('desvios')
				->onDelete('cascade')
				->onUpdate('cascade');

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
