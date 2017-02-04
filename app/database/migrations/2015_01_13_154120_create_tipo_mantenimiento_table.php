<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateTipoMantenimientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_mantenimiento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('cod', 5);
			$table->string('nombre');
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
		Schema::drop('tipo_mantenimiento');
	}

}
