<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateSectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sector', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('estacion_inicio');
			$table->string('estacion_termino');
			$table->integer('km_inicio');
			$table->integer('km_termino');
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
		Schema::drop('sector');
	}

}
