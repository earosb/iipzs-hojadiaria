<?php

/**
 *
 * @author earosb
 */

class MaterialRetiradoTableSeeder extends Seeder {

	public function run()
	{
        $now = date('Y-m-d H:i:s');
                
		DB::table('material_retirado')->insert(
			array(
				array(
                    'codigo' => '',
                    'nombre' => 'Durmientes Madera Impregnada 2,75 mt',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Durmientes Madera Impregnada 2,75 mt',
                    'clase' => 'Astilla',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Durmientes de Puente',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Durmiente especial desviador',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Tirafondos Nº 2',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Clavos rieleros',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Perno rielero',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Sillas para clavo',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Eclisas',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Perno talón aguja',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Riel (mlr)',
                    'clase' => 'R',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Agujas varios Tipos, Iz, Dr, largos',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'codigo' => '',
                    'nombre' => 'Cruzamientos Varios Tipos y Tg',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),

		));
	}

}