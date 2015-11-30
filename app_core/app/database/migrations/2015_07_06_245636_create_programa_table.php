<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programa', function(Blueprint $table)
		{
			$table->increments('id');
            $table->date('semana')->nullable();
            $table->date('vencimiento')->nullable();
			$table->string('causa');
			$table->boolean('realizado')->default(false);
            $table->integer('km_inicio');
            $table->integer('km_termino');
            $table->decimal('cantidad', 10, 2);
            $table->string('lun')->nullable();
            $table->string('mar')->nullable();
            $table->string('mie')->nullable();
            $table->string('juv')->nullable();
            $table->string('vie')->nullable();
            $table->string('sab')->nullable();
            $table->string('dom')->nullable();
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
		Schema::drop('programa');
	}

}
