<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeletedAtToTipoMantenimientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tipo_mantenimiento', function(Blueprint $table)
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
		Schema::table('tipo_mantenimiento', function(Blueprint $table)
		{
			$table->dropSoftDeletes();
		});
	}

}
