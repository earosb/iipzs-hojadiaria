<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateDesviadorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('desviador', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('km_inicio');

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
		Schema::drop('desviador');
	}

}
