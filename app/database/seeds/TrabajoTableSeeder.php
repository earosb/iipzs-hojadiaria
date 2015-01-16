<?php

/**
 *
 * @author earosb
 */

class TrabajoTableSeeder extends Seeder {

	public function run()
	{
		$now = date('Y-m-d H:i:s');

		DB::table('trabajo')->insert(
			array(
				array(
                        'nombre' => 'Colocación de Balasto',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sustitución Aislada de Durmientes de Madera',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sustitución de Durmientes de Puentes',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sustitución de Durmientes de Desviadores',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Reemplazo Continuo de Rieles',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Sustitución Aislada de Rieles',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Rehabilitación de Junturas',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Instalacion de Lubricadores de Curva',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Reparación Integral de Desviadores',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Nivelación y Alineación vía ',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Perfilado de Vía',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Nivelación y Alineación de Desviadores',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Reparación de Obras de Arte y Puentes Menores',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Instalar Cierro de Malla',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'nombre' => 'Instalar Cierro de Alambre',
                        'es_oficial' => '1',
                        'id_tipo_mantenimiento' => '2',
                        'id_padre' => '',
                        'created_at' => $now,
                		'updated_at' => $now
                ),
            ));
		
	}

}