<?php

/**
 *
 * @author earosb
 */

class MaterialTableSeeder extends Seeder {

	public function run()
	{
		$now = date('Y-m-d H:i:s');
                
		DB::table('material')->insert(
			array(
				array(
                                        'codigo' => '',
                                        'nombre' => 'Suministro y transporte de balasto',
                                        'es_oficial' => '1',
                                        'unidad' => 'm3',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'trabajo_id' => '16',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes madera impregnada 2,75 mts',
                                        'es_oficial' => '1',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'trabajo_id' => '17',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes de puente madera impregnada',
                                        'es_oficial' => '1',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'trabajo_id' => '18',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes especiales de desviador',
                                        'es_oficial' => '1',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'trabajo_id' => '19',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),

		));

	}

        public function down()
        {
                DB::table('material')->delete();
        }

}