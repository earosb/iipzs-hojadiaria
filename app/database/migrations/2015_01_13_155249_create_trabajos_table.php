<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->boolean('es_oficial');

			$table->integer('tipo_mantenimiento_id')->unsigned();
			$table->foreign('tipo_mantenimiento_id')->references('id')->on('tipo_mantenimiento');

			$table->integer('padre_id')->unsigned()->nullable();
			$table->foreign('padre_id')->references('id')->on('trabajo');

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
		Schema::drop('trabajo');
	}

}
