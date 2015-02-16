<?php

/**
 *
 * @author earosb
 */
use Carbon\Carbon;

class ConsultasController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /param
     *
     * @return Response
     */
    public function param()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        $grupos = GrupoTrabajo::all(array('id', 'base'));
        return View::make('consultas.index')
            ->with('grupos', $grupos)
            ->with('sectores', $sectores);
    }

    /**
     * Display a listing of the resource.
     * GET /consultas
     *
     * @return Response
     */
    public function index()
    {
        $input = array(
            'desde'      => Input::get('desde'),
            'hasta'      => Input::get('hasta'),
            'km_inicio'  => Input::get('km_inicio'),
            'km_termino' => Input::get('km_termino'),
        );
        $rules = array(
            'desde'      => 'required|date_format:d/m/Y|before:' . $input['hasta'],
            'hasta'      => 'required|date_format:d/m/Y|before:"now +1 day',
            'km_inicio'  => 'required|numeric',
            'km_termino' => 'required|numeric',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::to('s/param')->withInput()->withErrors($validator->messages());
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input['desde'] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input['hasta'] . '23:59:59');

        $km_inicio = $input['km_inicio'];
        $km_termino = $input['km_termino'];

        /**
         * Consulta detallada de trabajos
         */
        if (Sentry::getUser()->hasAccess(['consultas-avanzadas'])) {
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
                ->whereBetween('fecha', array($desde, $hasta), 'and')
                ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
                ->orderBy('hoja_diaria.fecha')
                ->get(array('fecha', 'block.estacion', 'detalle_hoja_diaria.km_inicio', 'detalle_hoja_diaria.km_termino', 'trabajo.nombre', 'trabajo.unidad', 'cantidad'));

        }


        $materiales = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->join('detalle_material_colocado', 'detalle_material_colocado.hoja_diaria_id', '=', 'detalle_material_colocado.id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->whereBetween('fecha', array($desde, $hasta), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino))
            ->where('detalle_material_colocado.reempleo', '=', '0')
            ->groupBy('material.nombre')
//            ->sum('detalle_material_colocado.cantidad')
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
//            ->get(array('material.nombre', 'detalle_material_colocado.cantidad', 'detalle_material_colocado.reempleo', 'material.unidad'));
            ->get();
        $materialesReempleo = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
            ->join('detalle_material_colocado', 'detalle_material_colocado.hoja_diaria_id', '=', 'detalle_material_colocado.id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->whereBetween('fecha', array($desde, $hasta), 'and')
            ->whereBetween('detalle_hoja_diaria.km_inicio', array($km_inicio, $km_termino), 'and')
            ->where('detalle_material_colocado.reempleo', '=', '1')
            ->groupBy('material.nombre')
            ->select('material.nombre', 'detalle_material_colocado.reempleo', 'material.unidad', DB::raw('SUM(detalle_material_colocado.cantidad) as cantidad'))
            ->get();

        return View::make('consultas.consulta')
            ->with('trabajos', $trabajos)
            ->with('materiales', $materiales)
            ->with('matReempleo', $materialesReempleo);
    }


    /**
     * Show the form for creating a new resource.
     * GET /consultas/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /consultas
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /consultas/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /consultas/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /consultas/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /consultas/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}