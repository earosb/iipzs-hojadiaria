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
            $table->date('semana')->nullable();
            $table->string('programa')->nullable();
            $table->string('lun')->nullable();
            $table->string('mar')->nullable();
            $table->string('mie')->nullable();
            $table->string('juv')->nullable();
            $table->string('vie')->nullable();
            $table->string('sab')->nullable();
            $table->string('dom')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->integer('km_inicio');
            $table->integer('km_termino');
            $table->decimal('cantidad', 10, 2);
            $table->text('observaciones')->nullable();

			/*$table->integer('causa_id')->unsigned();
			$table->foreign('causa_id')->references('id')->on('causa');*/
			$table->string('causa');

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
