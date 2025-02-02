<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 *
 * @author earosb
 */

class CreateMaterialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->float('valor');
			$table->boolean('es_oficial');
			$table->string('unidad',10);
			$table->string('proveedor')->nullable();

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
		Schema::drop('material');
	}

}
