<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDesviadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('desviadors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('km_inicio');

			$table->integer('id_block')
				->unsigned();
			$table->foreign('id_block')
				->references('id')
				->on('blocks');
				
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
		Schema::drop('desviadors');
	}

}
