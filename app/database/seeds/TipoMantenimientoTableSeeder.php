<?php

/**
 *
 * @author earosb
 */
class TipoMantenimientoTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('tipo_mantenimiento')->insert(
            array(
                array(
                    'nombre'     => 'Mantenimiento menor',
                    'cod'        => 'menor',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'nombre'     => 'Mantenimiento mayor',
                    'cod'        => 'mayor',
                    'created_at' => $now,
                    'updated_at' => $now
                )
            ));
    }

}