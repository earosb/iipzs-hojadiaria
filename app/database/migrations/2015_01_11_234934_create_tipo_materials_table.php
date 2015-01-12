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
		Schema::create('tipo_materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('unidad',20);
			$table->string('proveedor');
			$table->string('clase',20);
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
		Schema::drop('tipo_materials');
	}

}
