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
		Schema::create('material', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cantidad');
			
			$table->integer('id_tipo_material')->unsigned();
			$table->foreign('id_tipo_material')->references('id')->on('tipo_material')
				->onDelete('cascade')->onUpdate('cascade');

			
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
