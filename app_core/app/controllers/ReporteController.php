<?php

/**
 *
 * @author earosb
 */
use Carbon\Carbon;

class ReporteController extends \BaseController
{
    /**
     * Fomulario con los parámetros de la búsqueda
     * GET /r/param
     *
     * @return Response
     */
    public function param()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        $grupos = GrupoTrabajo::all(array('id', 'base'));
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
    public function index()
    {
        $input = Input::all();

        /**
         * @avanzada boolen
         */
        $avanzada = Sentry::getUser()->hasAccess(['reporte-avanzado']);

        $rules = array(
            'fecha_desde' => 'required|date_format:d/m/Y|before:' . $input['fecha_hasta'],
            'fecha_hasta' => 'required|date_format:d/m/Y|before:"now +1 day',
            'km_inicio' => 'required|numeric',
            'km_termino' => 'required|numeric',
            'action' => 'required'
        );

        if ($avanzada) $rules['grupo_via'] = $input['grupo_via'] == 'all' ? 'sometimes' : 'exists:grupo_trabajo,id';

        $messages = array(
            'before' => 'Debe seleccionar una fecha anterior.',
        );

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('r/param')->withInput()->withErrors($validator->messages());
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input['fecha_desde'] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input['fecha_hasta'] . '23:59:59');

        $km_inicio = $input['km_inicio'];
        $km_termino = $input['km_termino'];

        /**
         * @action string Tipo de consulta/reporte
         */
        $action = $input['action'];

        /** Trabajos
         * ******************************************/
        // Consulta detallada de trabajos
        if ($action == 'detallado') {
            if ($avanzada) {
                $grupo = $input['grupo_via'];
                if ($grupo == 'all') {
                    $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                        ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                        ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                        ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                        ->whereBetween('fecha', array($desde, $hasta), 'and')
                        ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                        ->orderBy('hoja_diaria.fecha')
                        ->get(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad', 'base'));
                } else {
                    $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                        ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                        ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                        ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                        ->whereBetween('fecha', array($desde, $hasta), 'and')
                        ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                        ->where('grupo_trabajo.id', $grupo)
                        ->orderBy('hoja_diaria.fecha')
                        ->get(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad', 'base'));
                }

            } else {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->whereBetween('fecha', array($desde, $hasta), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                    ->orderBy('hoja_diaria.fecha')
                    ->get(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad'));
            }

            // Consulta Resumida de trabajos
        } elseif ($action == 'resumido') {
            if ($avanzada) {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->whereBetween('fecha', array($desde, $hasta), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                    ->select('trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                    ->groupBy('trabajo.nombre')
                    ->get();

            } else {
                $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->whereBetween('fecha', array($desde, $hasta), 'and')
                    ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                    ->select('trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                    ->groupBy('trabajo.nombre')
                    ->get();
            }
        }

        /** Materiales Colocados
         * ******************************************/
        // Consulta agrupada de materiales colocados marcados como nuevos
        $materiales['nuevo'] = HojaDiaria::join('detalle_material_colocado', 'hoja_diaria.id', '=', 'detalle_material_colocado.hoja_diaria_id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->where('detalle_material_colocado.reempleo', '=', '0')
            ->whereBetween('hoja_diaria.fecha', array($desde, $hasta), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
            ->groupBy('material.nombre')
            ->get();

        // Consulta agrupada de materiales colocados marcados como de reempleo
        $materiales['reempleo'] = HojaDiaria::join('detalle_material_colocado', 'hoja_diaria.id', '=', 'detalle_material_colocado.hoja_diaria_id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->where('detalle_material_colocado.reempleo', '=', '1')
            ->whereBetween('hoja_diaria.fecha', array($desde, $hasta), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
            ->groupBy('material.nombre')
            ->get();

        /** Materiales Retirados
         * ******************************************/
        // Consulta agrupada de materiales retirados de la vía (Si es que tiene permisos)
        if ($avanzada) {
            $materialesRetirados['excluido'] = HojaDiaria::join('detalle_material_retirado', 'hoja_diaria.id', '=', 'detalle_material_retirado.hoja_diaria_id')
                ->join('material_retirado', 'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->where('detalle_material_retirado.reempleo', '=', '0')
                ->whereBetween('fecha', array($desde, $hasta), 'and')
                ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                ->select('material_retirado.nombre', 'detalle_material_retirado.reempleo', DB::raw('SUM(detalle_material_retirado.cantidad) as cantidad'))
                ->groupBy('material_retirado.nombre')
                ->get();

            $materialesRetirados['reempleo'] = HojaDiaria::join('detalle_material_retirado', 'hoja_diaria.id', '=', 'detalle_material_retirado.hoja_diaria_id')
                ->join('material_retirado', 'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->where('detalle_material_retirado.reempleo', '=', '1')
                ->whereBetween('fecha', array($desde, $hasta), 'and')
                ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                ->select('material_retirado.nombre', DB::raw('SUM(detalle_material_retirado.cantidad) as cantidad'))
                ->groupBy('material_retirado.nombre')
                ->get();
        } else {
            $materialesRetirados = null;
        }

        if ($action == 'detallado') {
            return View::make('reporte.detallado')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('avanzada', $avanzada)
                ->with('materialesRetirados', $materialesRetirados);
        } elseif ($action == 'resumido') {
            return View::make('reporte.resumido')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('avanzada', $avanzada)
                ->with('materialesRetirados', $materialesRetirados);
        } else {
            return App::abort(404);
        }
    }

    /**
     * despliega formulario para la generación de excel
     * @return $this
     */
    public function getForm()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        $year = Carbon::today()->year;
        return View::make('reporte.form')
            ->with('sectores', $sectores)
            ->with('year', $year);
    }

    /**
     * Recibe parámetros y genera excel formulario 2-3-4
     * @return $this
     */
    public function postForm()
    {
        $input = Input::all();

        $desde = $input['desde'];
        $hasta = $input['hasta'];
        $year = $input['year'];

        $rules = array(
            'desde' => 'required|numeric|between:1,12',
            'hasta' => 'required|numeric|between:' . $input['desde'] . ',12',
            'year' => 'required|numeric|between:2015,' . $year,
            'sector' => 'required|exists:sector,id',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }

        $sector = Sector::find($input['sector']);

        /*
                $blocks = $sector->blocks;
                $data = Sector::find($input['sector'])
                    ->rightJoin('block', 'block.sector_id', '=', 'sector.id')
                    ->join('detalle_hoja_diaria', 'detalle_hoja_diaria.id', '=', 'block.id')
                    ->join('hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->rightJoin('trabajo', 'trabajo.id', '=', 'detalle_hoja_diaria.trabajo_id')
                    ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                    ->where('trabajo.es_oficial', '=', '1', 'and')
                    ->where('tipo_mantenimiento.nombre', '=', 'Mantenimiento mayor')
                    ->select('block.estacion', 'trabajo.nombre', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                    ->groupBy('block.estacion', 'trabajo.nombre')
                    ->get();

                $trabajos = Trabajo::join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                    ->where('trabajo.es_oficial', '=', '1', 'and')
                    ->where('tipo_mantenimiento.nombre', '=', 'Mantenimiento mayor')
                    ->select('trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
                    ->get();

                return View::make('test')
                    ->with('blocks', $blocks)
                    ->with('trabajos', $trabajos)
                    ->with('data', $data);
        */

        // Nombre del archivo
        $filename = 'Form 2-3-4 ' . $sector->nombre . ' Año ' . $year . ' [' . $desde . '-' . $hasta . ']';

        Excel::create($filename, function ($excel) use ($sector, $year, $desde, $hasta) {
            $blocks = $sector->blocks;
            foreach (range($desde, $hasta) as $month) {

                // Nombre de cada hoja
                $monthName = date("M", mktime(0, 0, 0, $month, 1, $year));

                $excel->sheet($monthName, function ($sheet) use ($blocks) {

                    $sheet->setAutoSize(true);

//                    $sheet->mergeCells('B10:C10');
//                    $sheet->mergeCells('B11:C11');
//                    $sheet->mergeCells('B12:C12');
//                    $sheet->mergeCells('B13:C13');
//                    $sheet->mergeCells('B14:C14');
                    $sheet->mergeCells('A10:A14');
                    $sheet->mergeCells('B10:B14');
                    $sheet->mergeCells('C10:C14');
                    $sheet->mergeCells('B14:C14');
                    $sheet->mergeCells('D11:D12');

                    // Cabeceras
                    $sheet->appendRow(10, array('PART.', 'DESIGNACION', '', 'N°Bien'));
                    $sheet->appendRow(11, array('PART.', 'DESIGNACION', '', 'UBIC.'));
                    $sheet->appendRow(13, array('PART.', 'DESIGNACION', '', 'BLOCK'));
                    $sheet->appendRow(14, array('PART.', 'DESIGNACION', '', 'UNID.'));

                    // Blocks en cabecera
                    $columna = 'E';
                    $columnaSig = 'F';
                    $fila = 10;
                    foreach ($blocks as $block) {
                        // Nro bien
                        $tmp = $columna . $fila . ':' . $columnaSig . $fila;
                        $sheet->mergeCells($tmp);
                        $sheet->cell($columna . $fila, $block->nro_bien);

                        // Ubicación
                        $sheet->cell($columna . ($fila + 1), 'KM');
                        $sheet->cell($columnaSig . ($fila + 1), $block->km_inicio);
                        $sheet->cell($columna . ($fila + 2), 'KM');
                        $sheet->cell($columnaSig . ($fila + 2), $block->km_termino);

                        // Estación
                        $tmp = $columna . ($fila + 3) . ':' . $columnaSig . ($fila + 3);
                        $sheet->mergeCells($tmp);
                        $sheet->cell($columna . ($fila + 3), $block->estacion);

                        // INFORMA/RECIBE
                        $sheet->cell($columna . ($fila + 4), 'INFORMA');
                        $sheet->cell($columnaSig . ($fila + 4), 'RECIBE');

                        $columna++;
                        $columna++;
                        $columnaSig++;
                        $columnaSig++;
                    }

                    // Trabajos
                    $trabajos = Trabajo::join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                        ->where('trabajo.es_oficial', '=', '1', 'and')
                        ->where('tipo_mantenimiento.nombre', '=', 'Mantenimiento mayor')
                        ->select('trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
                        ->get();
                    $fila = 15;
                    foreach ($trabajos as $cont => $trabajo) {
                        $tmp = 'B' . $fila . ':' . 'C' . $fila;
                        $sheet->mergeCells($tmp);
                        $sheet->appendRow($fila, array(
                            ($cont + 1), $trabajo->nombre, $trabajo->unidad
                        ));
                        $fila++;
                    }


                });
            }

        })->export('xls');

        /*
                $filename = 'Form 2-3-4 ' . $sector->nombre . ' Año ' . $year . ' [' . $desde . '-' . $hasta . ']';

                Excel::create($filename, function ($excel) use ($sector, $year, $desde, $hasta) {

                    $excel->setTitle('Formularios 2 - 3 - 4');
                    $excel->setCreator('Icil-Icafal PZS');
                    $excel->setCompany('Icil Icafal Proyecto Zona Sur S.A.');
                    $excel->setLastModifiedBy('http://icilicafalpzs.cl/');
                    $excel->setDescription('Formularios 2-3-4 para EFE');

                    foreach (range($desde, $hasta) as $month) {

                        $monthName = date("M", mktime(0, 0, 0, $month, 1, $year));

                        $excel->sheet($monthName . " '" . $year, function ($sheet) use ($sector) {

                            $blocks = $sector->blocks;
                            $trabajos = Trabajo::join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                                ->where('trabajo.es_oficial', '=', '1', 'and')
                                ->where('tipo_mantenimiento.nombre', '=', 'Mantenimiento mayor')
                                ->select('trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
                                ->get();
                            // Using normal with()
                            $sheet->loadView('test')
                                ->with('blocks', $blocks)
                                ->with('trabajos', $trabajos);

                        });
                    }

                })->export('xls');
        */
    }

}