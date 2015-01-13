<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRamalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ramals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('km_inicio');
			$table->integer('km_termino');

			$table->integer('id_sector')
				->unsigned();
			$table->foreign('id_sector')
				->references('id')
				->on('sectors');
				
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
		Schema::drop('ramals');
	}

}
