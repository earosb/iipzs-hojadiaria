<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateTrabajoEjecutadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajo_ejecutado', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('observaciones')->nullable();

			$table->integer('trabajo_id')->unsigned();
			$table->foreign('trabajo_id')->references('id')->on('trabajo');	

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
		Schema::drop('trabajo_ejecutado');
	}

}
