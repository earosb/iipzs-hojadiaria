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
        if (!Request::ajax()) {
            \Debugbar::disable();
            return View::make('programar.index'); // \Debugbar::disable();
        }

        $query = DB::table('programar')
            ->join('trabajo', 'trabajo.id', '=', 'programar.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programar.grupo_trabajo_id');

        if (Input::get('semana')) {
            $semana = Carbon::createFromFormat('d/m/Y', Input::get('semana'))->toDateString();
            $query->where('programar.semana', '=', $semana)
                ->orWhere('programar.semana', '=', null);
        }

        if (Input::get('grupo')) {
            $query->where('programar.grupo_trabajo_id', '=', Input::get('grupo'));
            $query->where('programar.grupo_trabajo_id', '=', null);
        }

        $trabajos = $query->select('programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
            'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
            'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom',
            'grupo_trabajo.id as grupo_trabajo_id')
            ->orderBy('km_inicio')
            ->get();

        foreach ($trabajos as $trabajo) {
            $aux = $trabajo->semana;
            if ($aux) $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');
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
        $messages = array(
            'trabajo_id.required' => 'El campo trabajo es requerido.',
        );
        $validator = Validator::make($input, Programar::$rules, $messages);

        if ($validator->fails()) {
            return Response::json(
                array('error' => true, 'msg' => $validator->messages()));
        }

        $t = Programar::create($input);

        $trabajo = DB::table('programar')
            ->join('trabajo', 'trabajo.id', '=', 'programar.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programar.grupo_trabajo_id')
            ->select('programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom',
                'grupo_trabajo.id as grupo_trabajo_id')
            ->where('programar.id', '=', $t->id)
            ->first();

        $aux = $trabajo->semana;
        if ($aux) $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');

        return Response::json(
            array('error' => false, 'trabajo' => $trabajo));
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
//        Log::debug(Input::all());

        if ($input['semana']) {
            try {
                $programa->semana = Carbon::createFromFormat('d/m/Y', $input['semana']);
            } catch (Exception $e) {}
        }

        // $programa->programa = json_encode($input['programa']);
        $programa->lun = $input['lun'];
        $programa->mar = $input['mar'];
        $programa->mie = $input['mie'];
        $programa->juv = $input['juv'];
        $programa->vie = $input['vie'];
        $programa->sab = $input['sab'];
        $programa->dom = $input['dom'];

        $programa->km_inicio = $input['km_inicio'];
        $programa->km_termino = $input['km_termino'];
        $programa->cantidad = $input['cantidad'];
        $programa->observaciones = $input['observaciones'];
        $programa->causa = $input['causa'];
        $programa->grupo_trabajo_id = $input['grupo_trabajo_id'];

        $programa->save();

        return Response::json(['error' => false]);
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
        try {
            Programar::destroy($id);
            return Response::json(array('error' => false));
        } catch (Exception $e) {
            return Response::json(array('error' => true));
        }
    }

    /**
     * Generate pdf file.
     * GET /programar/pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $input = Input::all();

//        $rules = array(
//            'grupo_trabajo_id' => 'required|exists:grupo_trabajo,id',
//            'semana' => 'required|date_format:d/m/Y'
//        );
//
//        $validator = Validator::make($input, $rules);
//
//        if ($validator->fails()) {
//            return Redirect::back();
//        }
        $semana = Carbon::createFromFormat('d/m/Y', $input['semana'])->toDateString();

        if ($input['grupo_trabajo_id'] == 'all') {
            $grupo = null;
            $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->where('programar.semana', '=', $semana)
                ->orderBy('km_inicio')
                ->get(['programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);
        } else {
            $grupo = GrupoTrabajo::find($input['grupo_trabajo_id']);
            $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->where('programar.grupo_trabajo_id', '=', $grupo->id)
                ->where('programar.semana', '=', $semana)
                ->orderBy('km_inicio')
                ->get(['programar.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'fecha_inicio', 'fecha_termino', 'semana', 'programa',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);
        }

        $pdf = App::make('dompdf');
        $html = View::make('programar.pdf')
            ->with('trabajos', $trabajos)->with('grupo', $grupo)->with('semana', $input['semana']);
        $pdf->loadHTML($html)->setPaper('a4')->setOrientation('portrait'); // landscape | portrait
        return $pdf->stream();
    }


    public function updateDay($id)
    {
        $trabajo = Programar::find($id);
        $dia = Input::get('dia');
        switch ($dia) {
            case 'lun':
                $trabajo->lun == 'checked' ? $trabajo->lun = 'unchecked' : $trabajo->lun = 'checked';
                break;
            case 'mar':
                $trabajo->mar == 'checked' ? $trabajo->mar = 'unchecked' : $trabajo->mar = 'checked';
                break;
            case 'mie':
                $trabajo->mie == 'checked' ? $trabajo->mie = 'unchecked' : $trabajo->mie = 'checked';
                break;
            case 'juv':
                $trabajo->juv == 'checked' ? $trabajo->juv = 'unchecked' : $trabajo->juv = 'checked';
                break;
            case 'vie':
                $trabajo->vie == 'checked' ? $trabajo->vie = 'unchecked' : $trabajo->vie = 'checked';
                break;
            case 'sab':
                $trabajo->sab == 'checked' ? $trabajo->sab = 'unchecked' : $trabajo->sab = 'checked';
                break;
            case 'dom':
                $trabajo->dom == 'checked' ? $trabajo->dom = 'unchecked' : $trabajo->dom = 'checked';
                break;
        }
        $trabajo->save();
        return Response::json(['error' => false]);
    }

    public function updateGrupoTrabajo($id)
    {
        try {
            $id_grupo = Input::get('grupo_trabajo_id');

            $trabajo = Programar::find($id);
            $trabajo->grupo_trabajo_id = $id_grupo;
            $trabajo->save();

            return Response::json(['error' => false]);
        } catch (Exception $e) {
            return Response::json(['error' => true]);
        }
    }

}
