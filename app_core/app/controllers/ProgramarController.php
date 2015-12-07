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
        Log::debug('ProgramarController@index', ['input' => Input::all()]);

        if (!Request::ajax()) {
            \Debugbar::disable();
            return View::make('programar.index'); // \Debugbar::disable();
        }

        $query = DB::table('programa');

        if (Input::has('causa'))
            $query->where('programa.causa', 'LIKE', '%'.Input::get('causa').'%');

        if (Input::has('realizado') && Input::get('realizado') == 'true')
            $query->where('programa.realizado', true);
        else
            $query->where('programa.realizado', false);

        if (Input::has('semana')) {
            $semana = Carbon::createFromFormat('d/m/Y', Input::get('semana'))->toDateString();
            $query->where('programa.semana', '=', $semana);
            $query->orWhereNull('programa.semana');
        }

        if (Input::has('vencimiento')) {
            $vencimiento = Carbon::createFromFormat('d/m/Y', Input::get('vencimiento'))->toDateString();
            $query->where('programa.vencimiento', '=', $vencimiento);
            $query->orWhereNull('programa.vencimiento');
        }

        if (Input::has('grupo_trabajo_id') && Input::get('grupo_trabajo_id') != 'all') {
            $query->where('programa.grupo_trabajo_id', '=', Input::get('grupo_trabajo_id'));
            $query->orWhereNull('programa.grupo_trabajo_id');
        }

        $trabajos = $query->join('trabajo', 'trabajo.id', '=', 'programa.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programa.grupo_trabajo_id')
            ->select('programa.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                'grupo_trabajo_id', 'unidad', 'nombre', 'semana', 'no_programable', 'vencimiento', 'realizado',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom')
            ->orderBy('km_inicio')
            ->get();

        foreach ($trabajos as $trabajo) {
            $aux = $trabajo->semana;
            if ($aux) $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');
            $aux2 = $trabajo->vencimiento;
            if ($aux2) {
                $trabajo->vencimiento = Carbon::parse($aux2)->format('d/m/Y');
                $status = Carbon::parse($aux2)->diffInDays(null, false);

                // Una semana para la fecha de vencimiento
                if ($status >= -7) $trabajo->status = 'danger';
                // Dos semanas para la fecha de vencimiento
                elseif ($status >= -14 && $status < -7) $trabajo->status = 'warning';
                // Más de dos semanas para la fecha de vencimiento
                else $trabajo->status = 'success';
            }
            $trabajo->no_programable = $trabajo->no_programable == 1 ? true : false;
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
        $validator = Validator::make($input, Programa::$rules, $messages);

        if ($validator->fails()) {
            return Response::json(
                array('error' => true, 'msg' => $validator->messages()));
        }

        $t = Programa::create($input);

        $trabajo = DB::table('programa')
            ->join('trabajo', 'trabajo.id', '=', 'programa.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programa.grupo_trabajo_id')
            ->select('programa.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                'grupo_trabajo_id', 'unidad', 'nombre', 'semana', 'vencimiento',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom',
                'grupo_trabajo.id as grupo_trabajo_id')
            ->where('programa.id', '=', $t->id)
            ->first();

        $aux = $trabajo->semana;
        if ($aux) $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');
        $aux2 = $trabajo->vencimiento;
        if ($aux2) $trabajo->vencimiento = Carbon::parse($aux2)->format('d/m/Y');

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
        Log::debug('ProgramarController@update', ['id' => $id, 'input' => Input::all()]);
        $programa = Programa::find($id);

        $input = Input::all();

        if (Input::has('semana')) {
            try {
                $programa->semana = Carbon::createFromFormat('d/m/Y', $input['semana']);
            } catch (Exception $e) {
            }
        } else $programa->semana = null;

        if (Input::has('vencimiento')) {
            try {
                $programa->vencimiento = Carbon::createFromFormat('d/m/Y', $input['vencimiento']);
                $days = Carbon::parse($programa->vencimiento)->diffInDays(null, false);

                // Una semana para la fecha de vencimiento
                if ($days >= -7) $status = 'danger';
                // Dos semanas para la fecha de vencimiento
                elseif ($days >= -14 && $days < -7) $status = 'warning';
                // Más de dos semanas para la fecha de vencimiento
                else $status = 'success';
            } catch (Exception $e) {
            }
        } else {
            $programa->vencimiento = null;
            $status = '';
        }

        if (Input::has('realizado'))
            $programa->realizado = $input['realizado'];

        if (Input::get('no_programable')) {
            $programa->no_programable = $input['no_programable'];
            $programa->semana = null;
        } else $programa->no_programable = false;

        if (Input::has('causa'))
            $programa->causa = $input['causa'];

        if (Input::has('grupo_trabajo_id'))
            $programa->grupo_trabajo_id = $input['grupo_trabajo_id'];

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

        $programa->save();

        return Response::json(['error' => false, 'status' => $status]);
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
            Programa::destroy($id);
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

        $rules = array(
            //'grupo_trabajo_id' => 'required|exists:grupo_trabajo,id',
            'semana' => 'required|date_format:d/m/Y'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back();
        }

        $weekQuery = Carbon::createFromFormat('d/m/Y', $input['semana'])->toDateString();

        $startOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->startOfWeek()->toDateString();
        $startOfWeek = Carbon::parse($startOfWeek)->format('d/m/Y');
        $endOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->endOfWeek()->toDateString();
        $endOfWeek = Carbon::parse($endOfWeek)->format('d/m/Y');

        if ($input['grupo_trabajo_id'] == 'all') {
            $grupo = null;
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get(['programa.id', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'semana',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);
        } else {
            $grupo = GrupoTrabajo::find($input['grupo_trabajo_id']);
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get(['programa.id', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
                    'grupo_trabajo_id', 'unidad', 'nombre', 'semana',
                    'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom']);
        }

        $pdf = App::make('dompdf');
        $html = View::make('programar.pdf')
            ->with('trabajos', $trabajos)->with('grupo', $grupo)
            ->with('startOfWeek', $startOfWeek)
            ->with('endOfWeek', $endOfWeek);
        $pdf->loadHTML($html)->setPaper('a4')->setOrientation('portrait'); // landscape | portrait
        return $pdf->stream();
    }

    /**
     * Download Android App
     * GET /programar/download-app
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadApp()
    {
        $pathToFile = storage_path('static/iipzs-release.apk');
        return Response::download($pathToFile);
    }

}
