<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('trabajo');
			$table->text('observaciones');

			$table->integer('id_tipo_trabajo')
				->unsigned()
				->nullable();
			$table->foreign('id_tipo_trabajo')
				->references('id')
				->on('tipo_trabajos');
			
			$table->integer('id_hoja_diaria')
				->unsigned();
			$table->foreign('id_hoja_diaria')
				->references('id')
				->on('hoja_diarias');
			
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
		Schema::drop('trabajos');
	}

}
