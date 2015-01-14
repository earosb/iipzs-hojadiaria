<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateDesviosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('desvio', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');

			$table->integer('desviador_inicio_id')->unsigned()->nullable();
			$table->foreign('desviador_inicio_id')->references('id')->on('desviador');

			$table->integer('desviador_termino_id')->unsigned()->nullable();
			$table->foreign('desviador_termino_id')->references('id')->on('desviador');

			$table->integer('block_id')->unsigned();
			$table->foreign('block_id')->references('id')->on('block');
			
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
		Schema::drop('desvio');
	}

}
