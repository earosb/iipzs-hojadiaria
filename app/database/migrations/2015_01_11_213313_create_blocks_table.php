<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blocks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('estacion');
			$table->string('nro_bien',10);
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
		Schema::drop('blocks');
	}

}
