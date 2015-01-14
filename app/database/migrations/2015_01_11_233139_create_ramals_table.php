<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateRamalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ramal', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('km_inicio');
			$table->integer('km_termino');

			$table->integer('sector_id')->unsigned();
			$table->foreign('sector_id')->references('id')->on('sector');
				
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
		Schema::drop('ramal');
	}

}
