<?php

/**
 *
 * @author earosb
 */
class MaterialTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('material')->insert(
            array(
                array(
                    'nombre'     => 'Suministro y transporte de balasto',
                    'valor'      => '1.30',
                    'es_oficial' => '1',
                    'unidad'     => 'm3',
                    'proveedor'  => 'PZS',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmientes madera impregnada 2,75 mts',
                    'valor'      => '1.60',
                    'es_oficial' => '1',
                    'unidad'     => 'nro',
                    'proveedor'  => 'PZS',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmientes de puente madera impregnada',
                    'valor'      => '4.24',
                    'es_oficial' => '1',
                    'unidad'     => 'nro',
                    'proveedor'  => 'PZS',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Durmientes especiales de desviador',
                    'valor'      => '3.49',
                    'es_oficial' => '1',
                    'unidad'     => 'nro',
                    'proveedor'  => 'PZS',
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