<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeletedAtToGrupoTrabajoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('grupo_trabajo', function(Blueprint $table)
		{
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('grupo_trabajo', function(Blueprint $table)
		{
			$table->dropSoftDeletes();
		});
	}

}
