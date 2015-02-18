<?php

/**
 *
 * @author earosb
 */

class RamalTableSeeder extends Seeder {

	public function run()
	{
		$sector_1 = DB::table('sector')->select('id')->where('nombre', 'Sector 1')->first()->id;
		$now = date('Y-m-d H:i:s');
                        
		DB::table('ramal')->insert(
			array(
				array(
                        'nombre' => 'Coigue - Nacimiento',
                        'km_inicio' => '0',
                        'km_termino' => '520000',
                        'sector_id'	=>	$sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
        		)
		));
	}

}