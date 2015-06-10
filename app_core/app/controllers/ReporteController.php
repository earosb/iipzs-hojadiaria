<?php

/**
 *
 * @author earosb
 */
use Carbon\Carbon;

class ReporteController extends \BaseController
{
    private $months = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
    private $months_fullname = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Nov', 12 => 'Diciembre'];

    /**
     * Fomulario con los parámetros de la búsqueda
     * GET /r/param
     *
     * @return Response
     */
    public function param()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get(array('id', 'base'));

        return View::make('reporte.index')->with('grupos', $grupos)->with('sectores', $sectores);
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

        $rules = array('fecha_desde' => 'required|date_format:d/m/Y|before:' . $input['fecha_hasta'],
            'fecha_hasta' => 'required|date_format:d/m/Y|before:"now +1 day',
            'km_inicio' => 'required|numeric',
            'km_termino' => 'required|numeric',
            'action' => 'required');

        if ($avanzada)
            $rules['grupo_via'] = $input['grupo_via'] == 'all' ? 'sometimes' : 'exists:grupo_trabajo,id';

        $messages = array('before' => 'Debe seleccionar una fecha anterior.',);

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input['fecha_desde'] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input['fecha_hasta'] . '23:59:59');

        $km_inicio = $input['km_inicio'];
        $km_termino = $input['km_termino'];

        /**
         * @action string Tipo de consulta/reporte puede ser detallado o resumido.
         */
        $action = $input['action'];

        /**
         * @grupoVia boolean Determina si se filtran los resultados por grupo o no.
         */
        $grupoVia = Input::get('grupo_via') && Input::get('grupo_via') != 'all';

        $grupoVia ? $grupo = GrupoTrabajo::find($grupoVia) : $grupo = null;

        /*
        |--------------------------------------------------------------------------
        |   Trabajos
        |--------------------------------------------------------------------------
        */
        // Consulta detallada de trabajos
        if ($action == 'detallado') {
            $query = DB::table('hoja_diaria');

            if ($avanzada)
                $query->select(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad', 'base')); else
                $query->select(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad'));

            if ($grupoVia)
                $query->where('hoja_diaria.grupo_trabajo_id', Input::get('grupo_via'));

            $trabajos = $query->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')->whereBetween('fecha', array($desde, $hasta), 'and')->where('detalle_hoja_diaria.km_inicio', '>=', $km_inicio)->where('detalle_hoja_diaria.km_inicio', '<', $km_termino)->orderBy('hoja_diaria.fecha')->get();
            // Consulta Resumida de trabajos
        } elseif ($action == 'resumido') {
            $query = DB::table('hoja_diaria');
            if ($grupoVia)
                $query->where('hoja_diaria.grupo_trabajo_id', Input::get('grupo_via'));

            $trabajos = $query->select('trabajo.nombre', 'trabajo.unidad',
                DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                ->whereBetween('fecha', array($desde, $hasta), 'and')
                ->where('detalle_hoja_diaria.km_inicio', '>=', $km_inicio)
                ->where('detalle_hoja_diaria.km_inicio', '<', $km_termino)
                ->groupBy('trabajo.nombre')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        |   Materiales Colocados
        |--------------------------------------------------------------------------
        */
        // Consulta agrupada de materiales colocados nuevos y reempleo
        if ($grupoVia) {
            $queryNuevos = "m.nombre, m.unidad, sum(dmc.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_colocado dmc, material m
                    WHERE dmc.reempleo = '0'
                          AND hd.id = dmc.hoja_diaria_id
                          AND dmc.material_id = m.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                          AND hd.grupo_trabajo_id = " . Input::get('grupo_via') . "
                    GROUP BY  m.id;";
            $queryReempleo = "m.nombre, m.unidad, sum(dmc.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_colocado dmc, material m
                    WHERE dmc.reempleo = '1'
                          AND hd.id = dmc.hoja_diaria_id
                          AND dmc.material_id = m.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                          AND hd.grupo_trabajo_id = " . Input::get('grupo_via') . "
                    GROUP BY  m.id;";
        } else {
            $queryNuevos = "m.nombre, m.unidad, sum(dmc.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_colocado dmc, material m
                    WHERE dmc.reempleo = '0'
                          AND hd.id = dmc.hoja_diaria_id
                          AND dmc.material_id = m.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                    GROUP BY  m.id;";
            $queryReempleo = "m.nombre, m.unidad, sum(dmc.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_colocado dmc, material m
                    WHERE dmc.reempleo = '1'
                          AND hd.id = dmc.hoja_diaria_id
                          AND dmc.material_id = m.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                    GROUP BY  m.id;";
        }
        // Concateno el select aqui para que el IDE no me muestre error en la variable $query, tonteras de phpstorm
        $materiales['nuevo'] = DB::select('SELECT ' . $queryNuevos);
        if ($avanzada) {
            $materiales['reempleo'] = DB::select('SELECT ' . $queryReempleo);
        } else {
            $materiales['reempleo'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        |   Materiales Retirados
        |   Consulta agrupada de materiales retirados de la vía (si es que tiene permisos)
        |--------------------------------------------------------------------------
        */
        if ($avanzada) {
            if (Input::get('grupo_via') != 'all') {
                $queryExcluido = "mr.nombre, sum(dmr.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_retirado dmr, material_retirado mr
                    WHERE dmr.reempleo = '0'
                          AND hd.id = dmr.hoja_diaria_id
                          AND dmr.material_retirado_id = mr.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                          AND hd.grupo_trabajo_id = " . Input::get('grupo_via') . "
                    GROUP BY  mr.id;";
                $queryReempleo = "mr.nombre, sum(dmr.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_retirado dmr, material_retirado mr
                    WHERE dmr.reempleo = '1'
                          AND hd.id = dmr.hoja_diaria_id
                          AND dmr.material_retirado_id = mr.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                          AND hd.grupo_trabajo_id = " . Input::get('grupo_via') . "
                    GROUP BY  mr.id;";
            } else {
                $queryExcluido = "mr.nombre, sum(dmr.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_retirado dmr, material_retirado mr
                    WHERE dmr.reempleo = '0'
                          AND hd.id = dmr.hoja_diaria_id
                          AND dmr.material_retirado_id = mr.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                    GROUP BY  mr.id;";
                $queryReempleo = "mr.nombre, sum(dmr.cantidad) AS cantidad
                    FROM hoja_diaria hd, detalle_material_retirado dmr, material_retirado mr
                    WHERE dmr.reempleo = '1'
                          AND hd.id = dmr.hoja_diaria_id
                          AND dmr.material_retirado_id = mr.id
                          AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $km_inicio . "' AND dhd.km_inicio < '" . $km_termino . "' )
                          AND hd.fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'
                    GROUP BY  mr.id;";
            }

            $materialesRetirados['excluido'] = DB::select('SELECT ' . $queryExcluido);
            $materialesRetirados['reempleo'] = DB::select('SELECT ' . $queryReempleo);
        } else {
            $materialesRetirados = null;
        }

        if ($action == 'detallado') {
            return View::make('reporte.detallado')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('avanzada', $avanzada)
                ->with('materialesRetirados', $materialesRetirados)
                ->with('grupo', $grupo);
        } elseif ($action == 'resumido') {
            return View::make('reporte.resumido')
                ->with('trabajos', $trabajos)
                ->with('materiales', $materiales)
                ->with('avanzada', $avanzada)
                ->with('materialesRetirados', $materialesRetirados)
                ->with('grupo', $grupo);
        } else {
            App::abort(404);
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
        return View::make('reporte.form')->with('sectores', $sectores)->with('year', $year);
    }

    /**
     * Recibe parámetros y genera excel formulario 2-3-4 manteniminto mayor
     * @return $this
     */
    public function postFormMayor()
    {
        $input = Input::all();

        $mes = $input['mes'];
        $year = $input['year'];

        $rules = array('mes' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|between:2015,' . $year,
            'sector' => 'required|exists:sector,id',);

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        $sector = Sector::find($input['sector']);
        $mes_nombre = $this->months[$mes];
        // Nombre del archivo
        $filename = 'Form2-3-4[' . $sector->nombre . '][' . $mes_nombre . '][' . $year . ']';

        Excel::create($filename, function ($excel) use ($sector, $year, $mes, $mes_nombre) {

            $excel->setTitle('Formularios 2-3-4');
            $excel->setCreator('Icil-Icafal PZS');
            $excel->setCompany('Icil Icafal Proyecto Zona Sur S.A.');
            $excel->setLastModifiedBy('http://icilicafalpzs.cl/');
            $excel->setDescription('Formularios 2-3-4');

            $blocks = $sector->blocks;

            $desdeQuery = date('Y-m-01', strtotime($year . '-' . $mes . '-01'));
            $hastaQuery = date('Y-m-t', strtotime($year . '-' . $mes . '-01'));

            $excel->sheet($mes_nombre, function ($sheet) use ($sector, $blocks, $desdeQuery, $hastaQuery) {

                // Ancho de columnas automático
                $sheet->setAutoSize(true);

                // Sin bordes (deberían ser invisibles :/)
                //$sheet->setAllBorders('none');

                // Estilo de cabeceras
                $style = array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                $sheet->mergeCells('A2:A6');
                $sheet->mergeCells('B2:B6');
                $sheet->mergeCells('C2:C6');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('D3:D4');

                // Título formulario 2
                $sheet->cell('A1', 'Form. 2');

                // Cabeceras
                $sheet->appendRow(2, array('PART.', 'DESIGNACION', null, 'N°Bien'));
                $sheet->appendRow(3, array('PART.', 'DESIGNACION', null, 'UBIC.'));
                $sheet->appendRow(4, array('PART.', 'DESIGNACION', null, 'BLOCK'));
                $sheet->appendRow(5, array('PART.', 'DESIGNACION', null, 'UNID.'));

                // Blocks en cabecera
                $columna = 'E';
                $columnaSig = 'F';
                $fila = 2;
                foreach ($blocks as $block) {
                    // Nro bien
                    $tmp = $columna . $fila . ':' . $columnaSig . $fila;
                    $sheet->mergeCells($tmp);
                    $sheet->cell($columna . $fila, $block->nro_bien);
                    $sheet->getStyle($columna . $fila)->applyFromArray($style);
                    $sheet->setBorder($columna . $fila, 'thin');
                    // Ubicación
                    $sheet->cell($columna . ($fila + 1), 'KM');
                    $sheet->cell($columnaSig . ($fila + 1), $block->km_inicio);
                    $sheet->cell($columna . ($fila + 2), 'KM');
                    $sheet->cell($columnaSig . ($fila + 2), $block->km_termino);
                    $sheet->setBorder($columna . ($fila + 1), 'thin');
                    $sheet->setBorder($columna . ($fila + 2), 'thin');
                    $sheet->setBorder($columnaSig . ($fila + 1), 'thin');
                    $sheet->setBorder($columnaSig . ($fila + 2), 'thin');

                    // Estación
                    $tmp = $columna . ($fila + 3) . ':' . $columnaSig . ($fila + 3);
                    $sheet->mergeCells($tmp);
                    $sheet->cell($columna . ($fila + 3), $block->estacion);
                    $sheet->getStyle($columna . ($fila + 3))->applyFromArray($style);
                    $sheet->setBorder($columna . ($fila + 3), 'thin');

                    // INFORMA/RECIBE
                    $sheet->cell($columna . ($fila + 4), 'INFORMA');
                    $sheet->cell($columnaSig . ($fila + 4), 'RECIBE');
                    $sheet->setBorder($columna . ($fila + 4), 'thin');
                    $sheet->setBorder($columnaSig . ($fila + 4), 'thin');

                    $columna++;
                    $columna++;
                    $columnaSig++;
                    $columnaSig++;
                }

                // Trabajos
                $trabajos = Trabajo::where('trabajo.es_oficial', '=', '1', 'and')
                    ->where('tipo_mantenimiento.cod', '=', 'mayor')
                    ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                    ->select('trabajo.id', 'trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
                    ->get();

                $fila = $fila + 5;
                foreach ($trabajos as $cont => $trabajo) {
                    $tmp = 'B' . $fila . ':' . 'C' . $fila;
                    $sheet->mergeCells($tmp);
                    $sheet->appendRow($fila, array(($cont + 1), $trabajo->nombre, null, $trabajo->unidad));

                    $dataTrabajo = Trabajo::where('sector.id', '=', $sector->id)
                        ->where('trabajo.id', '=', $trabajo->id)
                        ->whereBetween('hoja_diaria.fecha', array($desdeQuery, $hastaQuery))
                        ->join('detalle_hoja_diaria', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                        ->join('hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                        ->join('block', 'block.id', '=', 'detalle_hoja_diaria.block_id')
                        ->join('sector', 'sector.id', '=', 'block.sector_id')
                        ->select('block.id', 'block.estacion', 'trabajo.id as trabajo_id', 'trabajo.nombre', 'trabajo.unidad',
                            DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
                        ->groupBy('block.id')
                        ->get();

                    $styleCell = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '66B2FF')));
                    $columna = 'E';
                    foreach ($blocks as $block) {
                        foreach ($dataTrabajo as $data) {
                            if ($block->id == $data->id) {
                                $sheet->cell($columna . $fila, $data->cantidad);
                                $sheet->getStyle($columna . $fila)->applyFromArray($styleCell);
                                break 1;
                            }
                        }
                        $columna++;
                        $columna++;
                    }
                    $fila++;
                }
                // Bordes
                //$sheet->setBorder('A10:AF29', 'thin');

                /***********************************************
                 * FORMULARIO 3
                 * *********************************************
                 */
                // Título Formulario 3
                $sheet->cell('A' . ($fila + 2), 'Form. 3');

                $sheet->mergeCells('A' . ($fila + 3) . ':B' . ($fila + 3));
                $sheet->appendRow(($fila + 3), array('B.- MATERIAL COLOCADO', null, 'PROVEEDOR', 'CLASE'));

                // Materiales colocados
                $materialesColocados = Material::where('es_oficial', '=', '1')->select('id', 'nombre', 'proveedor')->get();

                $fila = $fila + 4;
                $styleCell = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '66B2FF')));
                foreach ($materialesColocados as $cont => $matCol) {
                    $sheet->appendRow($fila, array(($cont + 1), $matCol->nombre, $matCol->proveedor, 'N'));
                    $sheet->appendRow($fila + 1, array(($cont + 1), $matCol->nombre, $matCol->proveedor, 'R'));

                    $columna = 'E';
                    foreach ($blocks as $block) {
                        $query = "SELECT m.nombre, dmc.reempleo, sum(dmc.cantidad) AS cantidad
                                        FROM hoja_diaria hd, detalle_material_colocado dmc, material m
                                        WHERE m.id = " . $matCol->id . "
                                        AND hd.id = dmc.hoja_diaria_id
                                        AND dmc.material_id = m.id
                                        AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $block->km_inicio . "' AND dhd.km_inicio < '" . $block->km_termino . "' )
                                        AND hd.fecha BETWEEN '" . $desdeQuery . "' AND '" . $hastaQuery . "' GROUP BY  m.id, dmc.reempleo";

                        $dataMaterial = DB::select($query);
                        foreach ($dataMaterial as $data) {

                            if ($data->reempleo == 0) {
                                $sheet->cell($columna . $fila, $data->cantidad);
                                $sheet->getStyle($columna . $fila)->applyFromArray($styleCell);
                            }
                            if ($data->reempleo == 1) {
                                $sheet->cell($columna . ($fila + 1), $data->cantidad);
                                $sheet->getStyle($columna . ($fila + 1))->applyFromArray($styleCell);
                            }


                        }
                        $columna++;
                        $columna++;
                    }
                    $fila++;
                    $fila++;
                }

                /***********************************************
                 * FORMULARIO 4
                 * *********************************************
                 */
                // Título Formulario 4
                $sheet->cell('A' . ($fila + 2), 'Form. 4');

                $sheet->mergeCells('A' . ($fila + 3) . ':B' . ($fila + 3));
                $sheet->appendRow(($fila + 3), array('C.- MATERIAL RETIRADO DE LA VIA', null, null, 'CLASE'));

                // Materiales retirados
                $materialesRetirados = MaterialRetirado::where('es_oficial', '=', '1')->select('id', 'nombre')->get();

                $fila = $fila + 4;
                $styleCell = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '66B2FF')));
                foreach ($materialesRetirados as $cont => $matRet) {
                    $tmp = 'B' . $fila . ':' . 'C' . $fila;
                    $sheet->mergeCells($tmp);
                    $tmp = 'B' . ($fila + 1) . ':' . 'C' . ($fila + 1);
                    $sheet->mergeCells($tmp);
                    $sheet->appendRow($fila, array(($cont + 1), $matRet->nombre, null, 'Exc.'));
                    $sheet->appendRow($fila + 1, array(($cont + 1), $matRet->nombre, null, 'R.'));

                    $columna = 'E';
                    foreach ($blocks as $block) {
                        $query = "SELECT mr.nombre, dmr.reempleo, sum(dmr.cantidad) AS cantidad
                                        FROM hoja_diaria hd, detalle_material_retirado dmr, material_retirado mr
                                        WHERE mr.id = " . $matRet->id . "
                                        AND hd.id = dmr.hoja_diaria_id
                                        AND dmr.material_retirado_id = mr.id
                                        AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '" . $block->km_inicio . "' AND dhd.km_inicio < '" . $block->km_termino . "' )
                                        AND hd.fecha BETWEEN '" . $desdeQuery . "' AND '" . $hastaQuery . "' GROUP BY  mr.id, dmr.reempleo";

                        $dataMaterialR = DB::select($query);
                        foreach ($dataMaterialR as $data) {
                            if ($data->reempleo == 0) {
                                $sheet->cell($columna . $fila, $data->cantidad);
                                $sheet->getStyle($columna . $fila)->applyFromArray($styleCell);
                            }
                            if ($data->reempleo == 1) {
                                $sheet->cell($columna . ($fila + 1), $data->cantidad);
                                $sheet->getStyle($columna . ($fila + 1))->applyFromArray($styleCell);
                            }
                        }
                        $columna++;
                        $columna++;
                    }
                    $fila++;
                    $fila++;
                }
            });

        })->store('xls', public_path('excel/' . $filename));

        // Checkbox descargar generadores
        if (Input::has('g')) $this->createGenerador($sector, $year, $mes, 'mayor', $filename);

        // Crear el zip
        $this->createZip($filename);

        // Borra la carpeta
        $this->deleteFolder('excel/' . $filename);

        return Response::download('excel/' . $filename . '.zip');

    }

    /**
     * Recibe parámetros y genera excel formulario 2-3-4 manteniminto mayor
     * @return $this
     */
    public function postFormMenor()
    {
        $input = Input::all();

        $mes = $input['mes'];
        $year = $input['year'];

        $rules = array('mes' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|between:2015,' . $year,
            'sector' => 'required|exists:sector,id',);

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        $sector = Sector::find($input['sector']);
        $mes_nombre = $this->months[$mes];

        // Nombre del archivo
        $filename = 'Form2[' . $sector->nombre . '][' . $year . '][' . $mes_nombre . '][Menor]';

        Excel::create($filename, function ($excel) use ($sector, $year, $mes, $mes_nombre) {

            $excel->setTitle('Formulario 2');
            $excel->setCreator('Icil-Icafal PZS');
            $excel->setCompany('Icil Icafal Proyecto Zona Sur S.A.');
            $excel->setLastModifiedBy('http://icilicafalpzs.cl/');
            $excel->setDescription('Formulario 2');

            $blocks = $sector->blocks;

            // Nombre de cada hoja
            $desdeQuery = date('Y-m-01', strtotime($year . '-' . $mes . '-01'));
            $hastaQuery = date('Y-m-t', strtotime($year . '-' . $mes . '-01'));

            $excel->sheet($mes_nombre, function ($sheet) use ($sector, $blocks, $desdeQuery, $hastaQuery) {

                // Ancho de columnas automático
                $sheet->setAutoSize(true);

                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('B2:C2');

                // Título formulario 2
                $sheet->cell('A1', 'Form. 2 Mantenimiento menor');

                // Cabecera
                $sheet->appendRow(2, array('PART.', 'DESIGNACION', null, 'BLOCK'));

                // Blocks en cabecera
                $columna = 'E';
                $fila = 2;
                foreach ($blocks as $block) {
                    $sheet->cell($columna . ($fila), $block->estacion);
                    $columna++;
                }

                // Trabajos
                $trabajos = Trabajo::where('trabajo.es_oficial', '=', '1', 'and')
                    ->where('tipo_mantenimiento.cod', '=', 'menor')
                    ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                    ->select('trabajo.id', 'trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
                    ->orderBy('orden', 'desc')
                    ->get();

                $fila = $fila + 1;
                foreach ($trabajos as $cont => $trabajo) {
                    $tmp = 'B' . $fila . ':' . 'C' . $fila;
                    $sheet->mergeCells($tmp);
                    $sheet->appendRow($fila, array(($cont + 1), $trabajo->nombre, null, $trabajo->unidad));

                    $dataTrabajo = Trabajo::where('sector.id', '=', $sector->id)->where('trabajo.id', '=', $trabajo->id)->whereBetween('hoja_diaria.fecha', array($desdeQuery, $hastaQuery))->join('detalle_hoja_diaria', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')->join('hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')->join('block', 'block.id', '=', 'detalle_hoja_diaria.block_id')->join('sector', 'sector.id', '=', 'block.sector_id')->select('block.id', 'block.estacion', 'trabajo.id as trabajo_id', 'trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))->groupBy('block.id')->get();

                    $columna = 'E';
                    foreach ($blocks as $block) {
                        foreach ($dataTrabajo as $data) {
                            if ($block->id == $data->id) {
                                $styleCell = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '66B2FF')));
                                $sheet->cell($columna . $fila, $data->cantidad);
                                $sheet->getStyle($columna . $fila)->applyFromArray($styleCell);
                                break 1;
                            }
                        }
                        $columna++;
                    }
                    $fila++;
                }
            });

        })->store('xls', public_path('excel/' . $filename));

        // Checkbox descargar generadores
        if (Input::has('g')) $this->createGenerador($sector, $year, $mes, 'menor', $filename);

        // Crear el zip
        $this->createZip($filename);

        // Borra la carpeta
        $this->deleteFolder('excel/' . $filename);

        return Response::download('excel/' . $filename . '.zip');
    }

    private function createGenerador($sector, $year, $mes, $tipoTrabajo, $path)
    {
        $desdeQuery = date('Y-m-01', strtotime($year . '-' . $mes . '-01'));
        $hastaQuery = date('Y-m-t', strtotime($year . '-' . $mes . '-01'));

        $blocks = $sector->blocks;

        $trabajosMeta['sector'] = $sector->nombre;
        $trabajosMeta['fecha'] = $this->months_fullname[$mes] . ' - ' . $year;

        $partidas = Trabajo::where('trabajo.es_oficial', '=', '1', 'and')
            ->where('tipo_mantenimiento.cod', '=', $tipoTrabajo)
            ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
            ->select('trabajo.id', 'trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
            ->get();

        foreach ($partidas as $partida) {
            $trabajos = array();
            $trabajosMeta['nombre'] = $partida->nombre;
            foreach ($blocks as $block) {
                $trabajosQuery = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array($desdeQuery, $hastaQuery), 'and')
                    ->where('block.id', '=', $block->id)
                    ->where('trabajo.id', '=', $partida->id)
                    ->select(
                        array(
                            'block.id',
                            'block.estacion',
                            'detalle_hoja_diaria.km_inicio',
                            'detalle_hoja_diaria.km_termino',
                            'detalle_hoja_diaria.desviador_id',
                            'detalle_hoja_diaria.desvio_id',
                            'trabajo.nombre',
                            'trabajo.unidad',
                            'detalle_hoja_diaria.cantidad'))
                    ->orderBy('detalle_hoja_diaria.km_inicio')
                    ->get();
                if (!$trabajosQuery->isEmpty()) {
                    $trabajos[] = $trabajosQuery;
                    $trabajosMeta['block'][] = $block->estacion;
                }
            }
            if (!empty($trabajos)) {
                Excel::create($trabajosMeta['nombre'], function ($excel) use ($trabajosMeta, $trabajos) {
                    foreach ($trabajos as $index => $t) {
                        $trabajosMeta['total'] = 0;
                        foreach ($t as $cont => $aux) {
                            $trabajosMeta['total'] += $aux->cantidad;
                        }

                        $excel->sheet($trabajosMeta['block'][$index], function ($sheet) use ($trabajosMeta, $t, $index) {
                            $sheet->setStyle(array('font' => array('name' => 'Arial', 'size' => 12)));
                            $sheet->setAutoSize(true);
                            $sheet->loadView('reporte.generador')
                                ->with('block', $trabajosMeta['block'][$index])
                                ->with('trabajosMeta', $trabajosMeta)
                                ->with('trabajos', $t);
                        });
                    }
                })->store('xls', public_path('excel/' . $path));
            }
            unset($trabajos);
        }
    }

    private static function createZip($path)
    {
        // Borra el archivo si es que existe
        if (file_exists(public_path('excel/' . $path) . '.zip')) unlink(public_path('excel/' . $path) . '.zip');

        $pathInfo = pathInfo(public_path('excel/' . $path));
        $parentPath = $pathInfo['dirname'];
        $dirName = $pathInfo['basename'];

        $z = new ZipArchive();
        $z->open(public_path('excel/' . $path . '.zip'), ZIPARCHIVE::CREATE);
        $z->addEmptyDir($dirName);
        self::folderToZip(public_path('excel/' . $path), $z, strlen("$parentPath/"));
        $z->close();
    }

    private static function folderToZip($folder, &$zipFile, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    self::folderToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    private static function deleteFolder($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    /**
     * Quita los tíldes y caracteres especiales
     * @param $cadena
     * @return string
     */
    private static function normaliza($cadena)
    {
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕñÑ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRrnN';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

}