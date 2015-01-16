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
                                        'unidad' => 'm3',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '1',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes madera impregnada 2,75 mts',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '2',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes de puente madera impregnada',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '3',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Durmientes especiales de desviador',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '4',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Sillas X para Tirafondos en Dtes de Madera ',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Reperforación de sillas para Tirafondos',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'R',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Tirafondos Nº 2',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Rieles nuevos 115 lb A:R:A: A  (Ton)',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Lubricadores de Riel',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Eclisa Planchuela tipo Z de 6 Agujeros',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Pernos para Eclisas Z',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Pernos para Eclisas ',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Anclas Z para Durmientes de Madera',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Cruzamientos Varios Tipos y Tg',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Agujas varios Tipos, Iz, Dr, largos',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Pernos Talón Aguja y Guarda Riel en General',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Balizas PK',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Cierro de Malla',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),
                                array(
                                        'codigo' => '',
                                        'nombre' => 'Cierro de Alambre',
                                        'unidad' => 'nro',
                                        'proveedor' => 'PZS',
                                        'clase' => 'N',
                                        'es_oficial' => '1',
                                        'trabajo_id' => '',
                                        'created_at' => $now,
                                        'updated_at' => $now
                                ),

		));
	}

}