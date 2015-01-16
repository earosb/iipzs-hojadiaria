<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('SectorTableSeeder');
		$this->call('BlockTableSeeder');
		$this->call('RamalTableSeeder');
		$this->call('TipoMantenimientoTableSeeder');
		$this->call('TrabajoTableSeeder');
		$this->call('MaterialRetiradoTableSeeder');
		$this->call('MaterialTableSeeder');
	}

}
