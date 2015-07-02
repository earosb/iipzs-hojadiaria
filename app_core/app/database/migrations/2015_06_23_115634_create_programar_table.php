<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programar', function(Blueprint $table)
		{
			$table->increments('id');
            $table->date('vencimiento')->nullable();
            $table->date('programada')->nullable();
            $table->integer('km_inicio');
            $table->integer('km_termino')->nullable();
            $table->decimal('cantidad', 10, 2);
            $table->string('causa');
            $table->text('observaciones')->nullable();

            $table->integer('trabajo_id')->unsigned();
            $table->foreign('trabajo_id')->references('id')->on('trabajo');

            $table->integer('grupo_trabajo_id')->unsigned()->nullable();
            $table->foreign('grupo_trabajo_id')->references('id')->on('grupo_trabajo');

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
		Schema::drop('programar');
	}

}
