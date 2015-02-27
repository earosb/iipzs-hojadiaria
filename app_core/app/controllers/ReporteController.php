<?php

/**
 *
 * @author earosb
 */
use Carbon\Carbon;

class ReporteController extends \BaseController {

    /**
     * Fomulario con los parámetros de la búsqueda
     * GET /r/param
     *
     * @return Response
     */
    public function param() {
        $sectores = Sector::all(array( 'id', 'nombre' ));
        $grupos = GrupoTrabajo::all(array( 'id', 'base' ));
        return View::make('reporte.index')
            ->with('grupos', $grupos)
            ->with('sectores', $sectores);
    }

    /**
     * Despliega el reporte detallado/resumido según el atributto action.
     * GET /r
     *
     * @return Response
     */
    public function index() {
        $input = Input::all();

        $rules = array(
            'fecha_desde' => 'required|date_format:d/m/Y|before:' . $input[ 'fecha_hasta' ],
            'fecha_hasta' => 'required|date_format:d/m/Y|before:"now +1 day',
            'km_inicio'   => 'required|numeric',
            'km_termino'  => 'required|numeric',
            'grupo_via'   => $input[ 'grupo_via' ] == 'all' ? 'sometimes' : 'sometimes|exists:grupo_trabajo,id',
            'action'      => 'required'
        );

        $validator = Validator::make($input, $rules);

        if ( $validator->fails() ) {
            return Redirect::to('r/param')->withInput()->withErrors($validator->messages());
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input[ 'fecha_desde' ] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input[ 'fecha_hasta' ] . '23:59:59');

        $km_inicio = $input[ 'km_inicio' ];
        $km_termino = $input[ 'km_termino' ];

        /**
         * Consulta detallada de trabajos
         */
        if ( $input[ 'action' ] == 'detallado' ) {
            if ( Sentry::getUser()->hasAccess([ 'consultas-avanzadas' ]) ) {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array( $desde, $hasta ), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
                    ->orderBy('hoja_diaria.fecha')
                    ->get(array( 'fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad', 'base' ));

            } else {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->whereBetween('fecha', array( $desde, $hasta ), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
                    ->orderBy('hoja_diaria.fecha')
                    ->get(array( 'fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad' ));
            }
            /**
             * Consulta Resumida de trabajos
             */
        } elseif ( $input[ 'action' ] == 'resumido' ) {
            if ( Sentry::getUser()->hasAccess([ 'consultas-avanzadas' ]) ) {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array( $desde, $hasta ), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
                    ->select('trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                    ->groupBy('trabajo.nombre')
                    ->get();

            } else {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array( $desde, $hasta ), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
                    ->select('trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                    ->groupBy('trabajo.nombre')
                    ->get();
            }
        }

        /**
         * Consulta agrupada de materiales colocados marcados como nuevos
         */
        $materiales[ 'nuevo' ] = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->join('detalle_material_colocado', 'detalle_material_colocado.hoja_diaria_id', '=', 'detalle_material_colocado.id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->where('detalle_material_colocado.reempleo', '=', '0')
            ->whereBetween('fecha', array( $desde, $hasta ), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
            ->groupBy('material.nombre')
            ->get();
        /**
         * Consulta agrupada de materiales colocados marcados como de reempleo
         */
        $materiales[ 'reempleo' ] = HojaDiaria
            ::join('detalle_material_colocado', 'hoja_diaria.id', '=', 'detalle_material_colocado.hoja_diaria_id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->where('detalle_material_colocado.reempleo', '=', '1')
            ->whereBetween('fecha', array( $desde, $hasta ), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
            ->groupBy('material.nombre')
            ->get();
        /**
         * Consulta agrupada de materiales retirados de la vía
         * Si es que tiene permisos
         */
        if ( Sentry::getUser()->hasAccess([ 'reporte-avanzado' ]) ) {
            $materialesRetirados = HojaDiaria
                ::join('detalle_material_retirado', 'hoja_diaria.id', '=', 'detalle_material_retirado.hoja_diaria_id')
                ->join('material_retirado', 'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->whereBetween('fecha', array( $desde, $hasta ), 'and')
                ->whereBetween('detalle_hoja_diaria.km_inicio', array( $km_inicio, $km_termino ))
                ->select('material_retirado.nombre', DB::raw('SUM(detalle_material_retirado.cantidad) as cantidad'))
                ->groupBy('material_retirado.nombre')
                ->get();
        } else {
            $materialesRetirados = null;
        }

        if ( $input[ 'action' ] == 'detallado' ) {
            return View::make('reporte.detallado')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('materialesRetirados', $materialesRetirados);
        } elseif ( $input[ 'action' ] == 'resumido' ) {
            return View::make('reporte.resumido')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('materialesRetirados', $materialesRetirados);
        } else {
            return Response::view('error.404');
        }
    }

}