<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepositoHistoricoColocadosView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement("
        CREATE VIEW deposito_historico_colocados_view AS

           (SELECT DATE(hd.fecha) AS fecha, (dmc.cantidad * -1) AS cantidad, m.id AS material_id, m.nombre AS material, d.nombre AS acopio, d.id AS acopio_id, 'Egreso hoja diaria' AS tipo
                FROM detalle_material_colocado AS dmc
                   INNER JOIN material AS m ON dmc.material_id = m.id
                   INNER JOIN hoja_diaria AS hd ON dmc.hoja_diaria_id = hd.id
                   INNER JOIN deposito AS d ON dmc.deposito_id = d.id)

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
        DB::statement('DROP VIEW IF EXISTS deposito_historico_colocados_view');
	}

}
