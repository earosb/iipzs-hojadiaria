<?php

/**
 *
 * @author earosb
 */
class GrupoTrabajosTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('grupo_trabajo')->insert(
            array(
                array(
                    'base'       => 'Reinaco',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Lautaro',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Temuco',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
            ));
    }

}