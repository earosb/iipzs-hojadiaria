<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHojaDiariasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hoja_diarias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha');
			$table->text('observaciones');

			$table->integer('id_grupo_trabajo')->unsigned()->nullable();
			$table->foreign('id_grupo_trabajo')->references('id')->on('grupo_trabajos');
			
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
		Schema::drop('hoja_diarias');
	}

}
