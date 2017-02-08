<?php

class DatabaseSeeder extends Seeder
{

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
        $this->call('TipoMantenimientoTableSeeder');
        $this->call('MaterialRetiradoTableSeeder');
        $this->call('TrabajoTableSeeder');
        $this->call('MaterialTableSeeder');
        $this->call('GrupoTrabajosTableSeeder');
        $this->call('PermisosTableSeeder');
    }

}
