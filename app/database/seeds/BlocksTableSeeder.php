<?php

/**
 *
 * @author earosb
 */

class BlocksTableSeeder extends Seeder {


	public function run()
	{
		// $sectors = DB::table('sectors')->get();
		$sector_1 = DB::table('sectors')->select('id')->where('nombre', 'Sector 1')->first()->id;
		$sector_2 = DB::table('sectors')->select('id')->where('nombre', 'Sector 2')->first()->id;

		$now = date('Y-m-d H:i:s');
                        
		DB::table('blocks')->insert(
			array(
				/* Sector 1 */
				array(
                        'estacion' => 'San Rosendo',
                        'nro_bien' => '3885-k',
                        'km_inicio' => '498800',
                        'km_termino' => '501200',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Laja',
                        'nro_bien' => '4516-3',
                        'km_inicio' => '501200',
                        'km_termino' => '511800',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Diuquín',
                        'nro_bien' => '4558-9',
                        'km_inicio' => '511800',
                        'km_termino' => '519500',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Millantú',
                        'nro_bien' => '4572-4',
                        'km_inicio' => '519500',
                        'km_termino' => '526900',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Santa Fe',
                        'nro_bien' => '4583-k',
                        'km_inicio' => '526900',
                        'km_termino' => '538400',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Coigüe',
                        'nro_bien' => '4738-7',
                        'km_inicio' => '538400',
                        'km_termino' => '551000',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Reinaco',
                        'nro_bien' => '4854-5',
                        'km_inicio' => '551000',
                        'km_termino' => '562900',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Las Viñas',
                        'nro_bien' => '5167-8',
                        'km_inicio' => '562900',
                        'km_termino' => '570700',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Mininco',
                        'nro_bien' => '5182-1',
                        'km_inicio' => '570700',
                        'km_termino' => '580200',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Lolenco',
                        'nro_bien' => '5194-5',
                        'km_inicio' => '580200',
                        'km_termino' => '588800',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Collipulli',
                        'nro_bien' => '5201-2',
                        'km_inicio' => '588800',
                        'km_termino' => '595900',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pidima',
                        'nro_bien' => '5224-0',
                        'km_inicio' => '595900',
                        'km_termino' => '602600',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Ercilla',
                        'nro_bien' => '5231-3',
                        'km_inicio' => '602900',
                        'km_termino' => '612900',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Paiulahueque',
                        'nro_bien' => '5251-8',
                        'km_inicio' => '612900',
                        'km_termino' => '625500',
                        'id_sector' => $sector_1,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                /* Sector 2 */
                array(
                        'estacion' => 'Victoria',
                        'nro_bien' => '5276-3',
                        'km_inicio' => '625500',
                        'km_termino' => '637400',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => 'Púa',
                        'nro_bien' => '5361-1',
                        'km_inicio' => '637400',
                        'km_termino' => '647800',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => 'Perquenco',
                        'nro_bien' => '5660-2',
                        'km_inicio' => '647800',
                        'km_termino' => '653300',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => '',
                        'nro_bien' => '',
                        'km_inicio' => '',
                        'km_termino' => '',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => '',
                        'nro_bien' => '',
                        'km_inicio' => '',
                        'km_termino' => '',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => '',
                        'nro_bien' => '',
                        'km_inicio' => '',
                        'km_termino' => '',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),array(
                        'estacion' => '',
                        'nro_bien' => '',
                        'km_inicio' => '',
                        'km_termino' => '',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
		));
	}

	public function down()
    {
		DB::table('blocks')->delete();
    }

}