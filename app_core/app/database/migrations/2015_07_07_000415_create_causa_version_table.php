<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCausaVersionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('causa_version', function(Blueprint $table)
		{
			$table->increments('id');
/*
            $table->integer('version');
            $table->date('vencimiento');

            $table->integer('causa_id')->unsigned();
            $table->foreign('causa_id')->references('id')->on('causa');
*/
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
		Schema::drop('causa_version');
	}

}
