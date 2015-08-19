<?php

use Carbon\Carbon;

class ProgramarController extends \BaseController
{
    /**
     * Display a listing of the resource.
     * GET /programar
     *
     * @return Response
     */
    public function index()
    {
        //\Debugbar::disable();
        $trabajos = Trabajo::lists('nombre', 'id');
        $grupos = GrupoTrabajo::lists('base', 'id');
        return View::make('programar.index-angular')
            ->with('trabajos', $trabajos)
            ->with('grupos', $grupos);
    }

    /**
     * Display a listing of the resource.
     * GET /programar/list
     *
     * @return Response
     */
    public function listJson()
    {
        if (Input::get('semana')) {
            $semana = Carbon::createFromFormat('d/m/Y', Input::get('semana'))->toDateString();
            $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->where('programar.semana', '=', $semana)
//                ->orWhere('programar.semana', '=', null)
                ->get(['programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);

        } else {
            $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                //->join('grupo_trabajo', 'grupo_trabajo.id', '=', 'programar.grupo_trabajo_id')
                ->orderBy('km_inicio')
                ->get(['programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);
        }

        foreach ($trabajos as $trabajo) {
            $aux = $trabajo->semana;
            if ($aux) {
                $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');
            }
        }

        return Response::json($trabajos);
    }

    /**
     * Store a newly created resource in storage.
     * POST /programar
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validator = Validator::make($input, Programar::$rules);

        if ($validator->fails()) {
            return Response::json(
                array('error' => true, 'msg' => $validator->messages()));
        }

        $t = Programar::create($input);
        $trabajo = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
            ->where('programar.id', '=', $t->id)
            ->first();

        return Response::json(
            array('error' => false, 't' => $trabajo));

    }

    /**
     * Display the specified resource.
     * GET /programar/{id}
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
     * GET /programar/{id}/edit
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
     * PUT /programar/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $programa = Programar::find($id);

        $input = Input::all();
        Log::debug(Input::all());
        $validator = Validator::make($input, Programar::$rules);

//        if ($validator->fails()) {
//            return Response::json(
//                array('error' => true, 'msg' => $validator->messages()));
//        }

        $programa->semana = Carbon::createFromFormat('d/m/Y', $input['semana']);
//        $programa->programa = json_encode($input['programa']);
        $programa->lun = $input['lun'];
        $programa->mar = $input['mar'];
        $programa->mie = $input['mie'];
        $programa->juv = $input['juv'];
        $programa->vie = $input['vie'];
        $programa->sab = $input['sab'];
        $programa->dom = $input['dom'];
//        $programa->fecha_inicio = Carbon::createFromFormat('d/m/Y', $input['fecha_inicio']);
//        $programa->fecha_termino = Carbon::createFromFormat('d/m/Y', $input['fecha_termino']);
        $programa->km_inicio = $input['km_inicio'];
        $programa->km_termino = $input['km_termino'];
        $programa->cantidad = $input['cantidad'];
        $programa->observaciones = $input['observaciones'];
        $programa->causa = $input['causa'];
        $programa->grupo_trabajo_id = $input['grupo_trabajo_id'];

        $programa->save();

        return Response::json(['error' => false, 'programa' => $programa]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /programar/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Programar::destroy($id);
        return Response::json(array('error' => false));
    }

    /**
     * Generate pdf file.
     * GET /programar/pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
            ->orderBy('km_inicio')
            ->get(['programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);

        $pdf = App::make('dompdf');
        $html = View::make('programar.pdf')->with('trabajos', $trabajos);
        $pdf->loadHTML($html)->setPaper('a4')->setOrientation('landscape'); // landscape | portrait
        return $pdf->stream();
    }

}
