<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrabajadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajadors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('rut',12);
			$table->string('nombre',100);
			$table->string('apellido_p',100);
			$table->string('apellido_m',100);
			$table->boolean('jefe_grupo')->default(false);
			$table->integer('id_grupo_trabajo')->unsigned();
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
		Schema::drop('trabajadors');
	}

}
