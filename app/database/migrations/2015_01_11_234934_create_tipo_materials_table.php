<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateTipoMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_material', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo')->nullable();
			$table->string('nombre');
			$table->string('unidad',20);
			$table->string('proveedor')->nullable();
			$table->string('clase',20)->nullable();
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
		Schema::drop('tipo_material');
	}

}
