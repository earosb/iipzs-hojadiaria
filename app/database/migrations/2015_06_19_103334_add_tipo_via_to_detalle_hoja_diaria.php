<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTipoViaToDetalleHojaDiaria extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_hoja_diaria', function(Blueprint $table)
		{
            $table->string('tipo_via', 20);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_hoja_diaria', function(Blueprint $table)
		{
            $table->dropColumn('tipo_via');
		});
	}

}
