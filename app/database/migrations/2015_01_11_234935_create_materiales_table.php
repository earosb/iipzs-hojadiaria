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
		Schema::create('materials', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('id_tipo_material')->unsigned();
			$table->foreign('id_tipo_material')
				->references('id')->on('tipo_materials')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->integer('cantidad');
			
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
		Schema::drop('materials');
	}

}
