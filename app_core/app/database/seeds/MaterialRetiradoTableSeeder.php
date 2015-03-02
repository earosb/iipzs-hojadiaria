<?php

/**
 *
 * @author earosb
 */
class MaterialRetiradoTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('material_retirado')->insert(
            array(
                array(
                    'nombre'     => 'Durmientes Madera Impregnada 2,75 mt',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmientes Madera Impregnada 2,75 mt',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmientes de Puente',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmiente especial desviador',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Tirafondos Nº 2',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Clavos rieleros',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Perno rielero',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Sillas para clavo',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Eclisas',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Perno talón aguja',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Riel (mlr)',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Agujas varios Tipos, Iz, Dr, largos',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Cruzamientos Varios Tipos y Tg',
                    'es_oficial' => '1',
                    'created_at' => $now,
                    'updated_at' => $now
                ),

            ));
    }

}