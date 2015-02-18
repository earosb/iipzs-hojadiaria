<?php

/**
 *
 * @author earosb
 */
class TrabajoTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('trabajo')->insert(
            array(
                array(
                    'nombre'                => 'Colocación de Balasto',
                    'valor'                 => '0.35',
                    'unidad'                => 'm3',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Sustitución Aislada de Durmientes de Madera',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Sustitución de Durmientes de Puentes',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Sustitución de Durmientes de Desviadores',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Reemplazo Continuo de Rieles',
                    'valor'                 => '0.35',
                    'unidad'                => 'mlv',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Sustitución Aislada de Rieles',
                    'valor'                 => '0.35',
                    'unidad'                => 'mlr',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Rehabilitación de Junturas',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Instalacion de Lubricadores de Curva',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Reparación Integral de Desviadores',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Nivelación y Alineación vía ',
                    'valor'                 => '0.35',
                    'unidad'                => 'mlv',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Perfilado de Vía',
                    'valor'                 => '0.35',
                    'unidad'                => 'mlv',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Nivelación y Alineación de Desviadores',
                    'valor'                 => '0.35',
                    'unidad'                => 'nro',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Reparación de Obras de Arte y Puentes Menores',
                    'valor'                 => '0.35',
                    'unidad'                => 'm3',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Instalar Cierro de Malla',
                    'valor'                 => '0.35',
                    'unidad'                => 'ml',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
                array(
                    'nombre'                => 'Instalar Cierro de Alambre',
                    'valor'                 => '0.35',
                    'unidad'                => 'ml',
                    'es_oficial'            => '1',
                    'tipo_mantenimiento_id' => '2',
                    'created_at'            => $now,
                    'updated_at'            => $now
                ),
            ));

    }

}