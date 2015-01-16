<?php

/**
 *
 * @author earosb
 */

class SectorTableSeeder extends Seeder {

	public function run()
	{
		$now = date('Y-m-d H:i:s');
                        
		DB::table('sector')->insert(
			array(
				array(
                        'nombre' => 'Sector 1',
                        'estacion_inicio' => 'San Rosendo',
                        'estacion_termino' => 'Victoria',
                        'km_inicio' => '498800',
                        'km_termino' => '625500',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sector 2',
                        'estacion_inicio' => 'Victoria',
                        'estacion_termino' => 'Temuco',
                        'km_inicio' => '625500',
                        'km_termino' => '690600',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sector 3',
                        'estacion_inicio' => 'Temuco',
                        'estacion_termino' => 'Mariquina',
                        'km_inicio' => '690600',
                        'km_termino' => '805650',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sector 4',
                        'estacion_inicio' => 'Mariquina',
                        'estacion_termino' => 'Osorno',
                        'km_inicio' => '805650',
                        'km_termino' => '953000',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sector 5',
                        'estacion_inicio' => 'Osorno',
                        'estacion_termino' => 'La Paloma',
                        'km_inicio' => '953000',
                        'km_termino' => '1066000',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
		));
	}

	public function down()
    {
		DB::table('sector')->delete();
    }

}