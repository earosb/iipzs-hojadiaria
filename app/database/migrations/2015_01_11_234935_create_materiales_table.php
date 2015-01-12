<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materiales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('unidad', 20);
			$table->integer('cantidad');
			$table->integer('id_trabajo')->unsigned();
			$table->foreign('id_trabajo')->references('id')->on('trabajos');
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
		Schema::drop('materiales');
	}

}
