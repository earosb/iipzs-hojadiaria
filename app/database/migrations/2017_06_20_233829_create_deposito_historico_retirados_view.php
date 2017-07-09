<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepositoHistoricoRetiradosView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement("
        CREATE VIEW deposito_historico_retirados_view AS
               
            (SELECT DATE(hd.fecha) AS fecha, dmr.cantidad, mr.id AS material_id, mr.nombre AS material, d.nombre AS acopio, d.id AS acopio_id, 'Ingreso hoja diaria' AS tipo
                FROM detalle_material_retirado AS dmr
                    INNER JOIN material_retirado AS mr ON dmr.material_retirado_id = mr.id
                    INNER JOIN hoja_diaria AS hd ON dmr.hoja_diaria_id = hd.id
                    INNER JOIN deposito AS d ON dmr.deposito_id = d.id)

            UNION ALL
            
            (SELECT DATE(c.fecha) AS fecha, c.cantidad, m.id AS material_id, m.nombre AS material, d.nombre AS acopio, d.id AS acopio_id, 'Carga' AS tipo
                 FROM carga AS c INNER JOIN material m ON c.material_id = m.id
                   INNER JOIN deposito AS d ON c.deposito_id = d.id
                 WHERE c.tipo = 'carga')
            
            UNION ALL

            (SELECT DATE(c.fecha) AS fecha, c.cantidad, m.id AS material_id, m.nombre AS material, d.nombre AS acopio, d.id AS acopio_id, 'Rectificación' AS tipo
                FROM carga AS c INNER JOIN material m ON c.material_id = m.id
                    INNER JOIN deposito AS d ON c.deposito_id = d.id
                WHERE c.tipo = 'rect')
            
            ORDER BY fecha DESC;

        ");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement('DROP VIEW IF EXISTS deposito_historico_retirados_view');
	}

}
