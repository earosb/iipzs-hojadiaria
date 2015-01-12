<?php

/**
 *
 * @author earosb
 */

class RamalsTableSeeder extends Seeder {

	public function run()
	{
		$sector_1 = DB::table('sectors')->select('id')->where('nombre', 'Sector 1')->first()->id;
		$now = date('Y-m-d H:i:s');
                        
		DB::table('ramals')->insert(
			array(
				array(
                        'nombre' => 'Coigue - Nacimiento',
                        'km_inicio' => '0',
                        'km_termino' => '5',
                        'id_sector'	=>	$sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
        		)
		));
	}

}