<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateDetalleHojaDiariaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_hoja_diaria', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('km_inicio');
			$table->integer('km_termino')->nullable();
			$table->integer('cantidad');

			$table->integer('trabajo_id')->unsigned();
			$table->foreign('trabajo_id')->references('id')->on('trabajo');

			$table->integer('hoja_diaria_id')->unsigned();
			$table->foreign('hoja_diaria_id')->references('id')->on('hoja_diaria');

			$table->integer('block_id')->unsigned()->nullable();
			$table->foreign('block_id')->references('id')->on('block');

			$table->integer('desviador_id')->unsigned()->nullable();
			$table->foreign('desviador_id')->references('id')->on('desviador');

			$table->integer('desvio_id')->unsigned()->nullable();
			$table->foreign('desvio_id')->references('id')->on('desvio');

			$table->integer('ramal_id')->unsigned()->nullable();
			$table->foreign('ramal_id')->references('id')->on('ramal');

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
		Schema::drop('detalle_hoja_diaria');
	}

}
