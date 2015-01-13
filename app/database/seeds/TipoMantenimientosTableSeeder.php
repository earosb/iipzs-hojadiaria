<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

/**
 *
 * @author earosb
 */

class TipoMantenimientosTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			TipoMantenimiento::create([

			]);
		}
	}

}