<?php

use MrJuliuss\Syntara\Facades\PermissionProvider;

class PermisosTableSeeder extends Seeder
{
    public function run()
    {
        PermissionProvider::createPermission(array( 'name' => 'Hoja Diaria', 'value' => 'hoja-diaria', 'description' => 'CREAR/EDITAR/BORRAR hojas diarias' ));
        PermissionProvider::createPermission(array( 'name' => 'Reporte', 'value' => 'reporte', 'description' => 'Ver reportes simples con trabajos/ubicación/fecha/materiales-colocados' ));
        PermissionProvider::createPermission(array( 'name' => 'Reporte Avanzado', 'value' => 'reporte-avanzado', 'description' => 'Crear reportes avanzados TODA la información disponible' ));
        PermissionProvider::createPermission(array( 'name' => 'Mantención', 'value' => 'mantencion', 'description' => 'Mantención de datos, CREAR/EDITAR/BORRAR ¡¡¡TODO!!!' ));
        PermissionProvider::createPermission(array( 'name' => 'Editor', 'value' => 'editor', 'description' => 'CREAR vías/trabajos/materiales desde formulario hoja diaria' ));
        PermissionProvider::createPermission(array( 'name' => 'Form 2-3-4', 'value' => 'form2-3-4', 'description' => 'Generar formularios 2-3-4' ));
    }

}