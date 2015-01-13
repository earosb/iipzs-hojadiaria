<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */
class CreateHojaDiariasTable extends Migration {

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
			$table->text('observaciones')->nullable();

			$table->integer('id_grupo_trabajo')->unsigned()->nullable();
			$table->foreign('id_grupo_trabajo')->references('id')->on('grupo_trabajo');
			
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
