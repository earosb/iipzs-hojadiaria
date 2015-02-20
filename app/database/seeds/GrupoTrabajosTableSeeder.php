<?php

/**
 *
 * @author earosb
 */
class GrupoTrabajosTableSeeder extends Seeder {

    public function run() {
        $now = date('Y-m-d H:i:s');

        DB::table('grupo_trabajo')->insert(
            array(
                array(
                    'base'       => 'Erwin Flores',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Frutillar',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'La Unión',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Lanco',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Loncoche',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Lubricadores',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Osorno',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Reinaco',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Roce',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Temuco',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
                array(
                    'base'       => 'Victoria',
                    'created_at' => $now,
                    'updated_at' => $now
                ),
            ));
    }
}