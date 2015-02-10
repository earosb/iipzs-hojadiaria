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
                    'nombre' => 'Durmientes Madera Impregnada 2,75 mt',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Durmientes Madera Impregnada 2,75 mt',
                    'clase' => 'Astilla',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Durmientes de Puente',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Durmiente especial desviador',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Tirafondos Nº 2',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Clavos rieleros',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Perno rielero',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Sillas para clavo',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Eclisas',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Perno talón aguja',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Riel (mlr)',
                    'clase' => 'R',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Agujas varios Tipos, Iz, Dr, largos',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),
				array(
                    'nombre' => 'Cruzamientos Varios Tipos y Tg',
                    'clase' => 'Exc.',
                    'es_oficial' => '1',
                    'created_at' => $now,
            		'updated_at' => $now
	    		),

		));
	}

}