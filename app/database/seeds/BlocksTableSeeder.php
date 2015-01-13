<?php

/**
 *
 * @author earosb
 */

class BlocksTableSeeder extends Seeder {


	public function run()
	{
		// $sectors = DB::table('sectors')->get();
		$sector_1 = DB::table('sector')->select('id')->where('nombre', 'Sector 1')->first()->id;
		$sector_2 = DB::table('sector')->select('id')->where('nombre', 'Sector 2')->first()->id;
		$sector_3 = DB::table('sector')->select('id')->where('nombre', 'Sector 3')->first()->id;
		$sector_4 = DB::table('sector')->select('id')->where('nombre', 'Sector 4')->first()->id;
		$sector_5 = DB::table('sector')->select('id')->where('nombre', 'Sector 5')->first()->id;

		$now = date('Y-m-d H:i:s');
                        
		DB::table('block')->insert(
			array(
				/***** Sector 1 *****/
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

                /***** Sector 2 *****/
                array(
                        'estacion' => 'Victoria',
                        'nro_bien' => '5276-3',
                        'km_inicio' => '625500',
                        'km_termino' => '637400',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Púa',
                        'nro_bien' => '5361-1',
                        'km_inicio' => '637400',
                        'km_termino' => '647800',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Perquenco',
                        'nro_bien' => '5660-2',
                        'km_inicio' => '647800',
                        'km_termino' => '653300',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Quillem',
                        'nro_bien' => '5667-k',
                        'km_inicio' => '653300',
                        'km_termino' => '661500',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Lautaro',
                        'nro_bien' => '5682-3',
                        'km_inicio' => '661500',
                        'km_termino' => '674400',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pillanlelbun',
                        'nro_bien' => '5727-7',
                        'km_inicio' => '674400',
                        'km_termino' => '680900',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Cajón',
                        'nro_bien' => '5839-7',
                        'km_inicio' => '680900',
                        'km_termino' => '690600',
                        'id_sector' => $sector_2,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                /***** Sector 3 *****/
                array(
                        'estacion' => 'Temuco',
                        'nro_bien' => '5843-5',
                        'km_inicio' => '690600',
                        'km_termino' => '693000',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'P. Las Casas',
                        'nro_bien' => '6032-4',
                        'km_inicio' => '693000',
                        'km_termino' => '702400',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Metrenco',
                        'nro_bien' => '6043-k',
                        'km_inicio' => '702400',
                        'km_termino' => '706800',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Quepe',
                        'nro_bien' => '6068-5',
                        'km_inicio' => '706800',
                        'km_termino' => '715900',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Freire',
                        'nro_bien' => '6105-3',
                        'km_inicio' => '715900',
                        'km_termino' => '720000',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pitrufquén',
                        'nro_bien' => '6292-0',
                        'km_inicio' => '720000',
                        'km_termino' => '733700',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Gorbea',
                        'nro_bien' => '6313-7',
                        'km_inicio' => '733700',
                        'km_termino' => '740200',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Quitratué',
                        'nro_bien' => '6313-7',
                        'km_inicio' => '740200',
                        'km_termino' => '749400',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Lastarria',
                        'nro_bien' => '6342-0',
                        'km_inicio' => '749400',
                        'km_termino' => '760200',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Afquintué',
                        'nro_bien' => '6889-9',
                        'km_inicio' => '760200',
                        'km_termino' => '769500',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Loncoche',
                        'nro_bien' => '6379-k',
                        'km_inicio' => '769500',
                        'km_termino' => '777900',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'La paz',
                        'nro_bien' => '6502-4',
                        'km_inicio' => '777900',
                        'km_termino' => '785300',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Lanco',
                        'nro_bien' => '6515-6',
                        'km_inicio' => '785300',
                        'km_termino' => '798000',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Ciruelos',
                        'nro_bien' => '6657-8',
                        'km_inicio' => '798000',
                        'km_termino' => '805000',
                        'id_sector' => $sector_3,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                /***** Sector 4 *****/
                array(
                        'estacion' => 'Mariquina',
                        'nro_bien' => '6671-3',
                        'km_inicio' => '805650',
                        'km_termino' => '817000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Máfil',
                        'nro_bien' => '6888-8',
                        'km_inicio' => '817000',
                        'km_termino' => '830000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Mulpún',
                        'nro_bien' => '6704-3',
                        'km_inicio' => '830000',
                        'km_termino' => '835000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Antilhue',
                        'nro_bien' => '6715-9',
                        'km_inicio' => '835000',
                        'km_termino' => '842000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Purey',
                        'nro_bien' => '6715-9',
                        'km_inicio' => '842000',
                        'km_termino' => '849000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Los lagos',
                        'nro_bien' => '6887-2',
                        'km_inicio' => '849000',
                        'km_termino' => '858000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Lipingue',
                        'nro_bien' => '6993-3',
                        'km_inicio' => '858000',
                        'km_termino' => '866000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Reumén',
                        'nro_bien' => '7006-0',
                        'km_inicio' => '866000',
                        'km_termino' => '876000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Paillaco',
                        'nro_bien' => '7019-2',
                        'km_inicio' => '876000',
                        'km_termino' => '886000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pichirropulli',
                        'nro_bien' => '7031-1',
                        'km_inicio' => '886000',
                        'km_termino' => '895000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Conales',
                        'nro_bien' => '13856-0',
                        'km_inicio' => '895000',
                        'km_termino' => '902000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Rapaco',
                        'nro_bien' => '7053-2',
                        'km_inicio' => '902000',
                        'km_termino' => '910000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'La Unión',
                        'nro_bien' => '7095-8',
                        'km_inicio' => '910000',
                        'km_termino' => '923000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Trumao',
                        'nro_bien' => '7222-5',
                        'km_inicio' => '923000',
                        'km_termino' => '935000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Caracol',
                        'nro_bien' => '7235-7',
                        'km_inicio' => '935000',
                        'km_termino' => '942000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Chacayal',
                        'nro_bien' => '7249-7',
                        'km_inicio' => '942000',
                        'km_termino' => '953000',
                        'id_sector' => $sector_4,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                /***** Sector 5 *****/
                array(
                        'estacion' => 'Osorno',
                        'nro_bien' => '7273-K',
                        'km_inicio' => '953000',
                        'km_termino' => '963000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Sagllue',
                        'nro_bien' => '7386-8',
                        'km_inicio' => '963000',
                        'km_termino' => '972000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Chahuilco',
                        'nro_bien' => '7397-3',
                        'km_inicio' => '972000',
                        'km_termino' => '982000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Rio Negro',
                        'nro_bien' => '7409-0',
                        'km_inicio' => '982000',
                        'km_termino' => '996000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Purranque',
                        'nro_bien' => '7427-9',
                        'km_inicio' => '996000',
                        'km_termino' => '1000000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Corte Alto',
                        'nro_bien' => '7437-6',
                        'km_inicio' => '1000000',
                        'km_termino' => '1007000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Casma',
                        'nro_bien' => '7545-3',
                        'km_inicio' => '1007000',
                        'km_termino' => '1021000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Frutillar',
                        'nro_bien' => '7556-9',
                        'km_inicio' => '1021000',
                        'km_termino' => '1029000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pellines',
                        'nro_bien' => '7572-0',
                        'km_inicio' => '1029000',
                        'km_termino' => '1039000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Llanquihue',
                        'nro_bien' => '7599-2',
                        'km_inicio' => '1039000',
                        'km_termino' => '1047000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Pto. Varas',
                        'nro_bien' => '7616-6',
                        'km_inicio' => '1047000',
                        'km_termino' => '1059000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'Alerce',
                        'nro_bien' => '7639-5',
                        'km_inicio' => '1059000',
                        'km_termino' => '1066000',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),
                array(
                        'estacion' => 'La Paloma',
                        'nro_bien' => 'xxxx-x',
                        'km_inicio' => '1066000',
                        'km_termino' => '1066100',
                        'id_sector' => $sector_5,
                        'created_at' => $now,
                		'updated_at' => $now
                ),

		));
	}

	public function down()
    {
		DB::table('block')->delete();
    }

}