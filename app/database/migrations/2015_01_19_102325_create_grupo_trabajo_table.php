<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateGrupoTrabajoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_trabajo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('base');
			$table->timestamps();
		});

		Schema::table('hoja_diaria', function(Blueprint $table)
		{
			$table->dropColumn('grupo_via');
			$table->integer('grupo_via_id')->unsigned();
			$table->foreign('grupo_via_id')->references('id')->on('grupo_trabajo');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grupo_trabajo');
	}

}
