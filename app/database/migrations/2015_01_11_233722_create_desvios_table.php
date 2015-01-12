<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDesviosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('desvios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');

			$table->integer('id_desviador_inicio')->unsigned()->nullable();
			$table->foreign('id_desviador_inicio')->references('id')->on('desviadors');

			$table->integer('id_desviador_termino')->unsigned()->nullable();
			$table->foreign('id_desviador_termino')->references('id')->on('desviadors');

			$table->integer('id_block')->unsigned();
			$table->foreign('id_block')->references('id')->on('blocks');
			
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
		Schema::drop('desvios');
	}

}
