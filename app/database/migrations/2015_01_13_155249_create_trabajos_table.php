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

			$table->integer('id_tipo_mantenimiento')->unsigned();
			$table->foreign('id_tipo_mantenimiento')->references('id')->on('tipo_mantenimiento');

			$table->integer('id_padre')->unsigned()->nullable();
			$table->foreign('id_padre')->references('id')->on('trabajo');

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
