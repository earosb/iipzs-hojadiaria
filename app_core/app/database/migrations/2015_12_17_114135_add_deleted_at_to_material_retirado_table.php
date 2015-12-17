<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeletedAtToMaterialRetiradoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('material_retirado', function(Blueprint $table)
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
		Schema::table('material_retirado', function(Blueprint $table)
		{
			$table->dropSoftDeletes();
		});
	}

}
