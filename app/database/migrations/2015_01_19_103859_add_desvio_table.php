<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class AddDesvioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('desvio', function(Blueprint $table)
		{
			$table->integer('desviador_norte_id')->unsigned()->nullable();
			$table->foreign('desviador_norte_id')->references('id')->on('desviador');

			$table->integer('desviador_sur_id')->unsigned()->nullable();
			$table->foreign('desviador_sur_id')->references('id')->on('desviador');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('desvio', function(Blueprint $table)
		{
			$table->dropColumn('desviador_norte_id');
			$table->dropColumn('desviador_sur_id');
		});
	}

}
