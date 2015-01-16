<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateHojaDiariaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hoja_diaria', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha');
			$table->string('grupo_via');
			$table->text('observaciones')->nullable();
			
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
		Schema::drop('hoja_diaria');
	}

}
