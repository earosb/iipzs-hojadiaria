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
            return View::make('programar.index');
        }

        $query = DB::table('programa');

        if (Input::has('causa'))
            $query->where('programa.causa', 'LIKE', '%' . Input::get('causa') . '%');

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
            ->select('programa.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones', 'obs_ce',
                'grupo_trabajo_id', 'unidad', 'nombre', 'semana', 'no_programable', 'vencimiento', 'realizado',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom')
            ->orderBy('km_inicio')
            ->get();

        foreach ($trabajos as $trabajo) {
            $trabajo->selected = false;
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

    public function updateSelected()
    {
        $input = Input::all();

        $modal = $input['modal'];
        $trabajos = $input['trabajos'];
        $status = array();

        foreach ($trabajos as $trabajo) {
            $programa = Programa::find($trabajo['id']);

            if (isset($modal['causa']))
                $programa->causa = $modal['causa'];

            if (isset($modal['grupo_trabajo_id']))
                $programa->grupo_trabajo_id = $modal['grupo_trabajo_id'];

            if (isset($modal['semana'])) {
                try {
                    $programa->semana = Carbon::createFromFormat('d/m/Y', $modal['semana']);
                } catch (Exception $e) {}
            }

            if (isset($modal['vencimiento'])) {
                try {
                    $programa->vencimiento = Carbon::createFromFormat('d/m/Y', $modal['vencimiento']);
                    $days = Carbon::parse($programa->vencimiento)->diffInDays(null, false);

                    // Una semana para la fecha de vencimiento
                    if ($days >= -7) $class = 'danger';
                    // Dos semanas para la fecha de vencimiento
                    elseif ($days >= -14 && $days < -7) $class = 'warning';
                    // Más de dos semanas para la fecha de vencimiento
                    else $class = 'success';

                    array_push($status, ['id' => $programa->id, 'class' => $class]);
                } catch (Exception $e) {}
            }

            if (isset($modal['lun']))
                $programa->lun = $modal['lun'];

            if (isset($modal['mar']))
                $programa->mar = $modal['mar'];

            if (isset($modal['mie']))
                $programa->mie = $modal['mie'];

            if (isset($modal['juv']))
                $programa->juv = $modal['juv'];

            if (isset($modal['vie']))
                $programa->vie = $modal['vie'];

            if (isset($modal['sab']))
                $programa->sab = $modal['sab'];

            if (isset($modal['dom']))
                $programa->dom = $modal['dom'];

            $programa->save();
        }
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
     * @return Response
     */
    public function getPrograma()
    {
        $input = Input::all();

        $rules = array('semana' => 'required|date_format:d/m/Y');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back();
        }

        if ($input['action'] == 'pdf') {
            return $this->pdf($input);
        } elseif ($input['action'] == 'csv') {
            return $this->csv($input);
        } else {
            return Redirect::back();
        }
    }

    /**
     * @param $input
     * @return Response
     */
    public function pdf($input)
    {
        //300 seconds = 5 minutes
        ini_set('max_execution_time', 300);

        $weekQuery = Carbon::createFromFormat('d/m/Y', $input['semana'])->toDateString();

        $startOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->startOfWeek()->toDateString();
        $startOfWeek = Carbon::parse($startOfWeek)->format('d/m/Y');
        $endOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->endOfWeek()->toDateString();
        $endOfWeek = Carbon::parse($endOfWeek)->format('d/m/Y');

        $fields = ['programa.id', 'cantidad', 'km_inicio', 'km_termino', 'observaciones',
            'grupo_trabajo_id', 'unidad', 'trabajo.nombre', 'semana',
            'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom'];

        if (!Input::has('grupo') || $input['grupo'] == 'all') {
            $grupo = null;
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get($fields);
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio', 'asc')
                ->get($fields);
        } else {
            $grupo = GrupoTrabajo::find($input['grupo']);
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get($fields);
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('trabajo.nombre', 'asc')
                ->orderBy('km_inicio', 'asc')
                ->get($fields);
        }

        $showObs = Input::has('obs') ? true : false;

        if (Input::has('orientation')) $orientation = $input['orientation'];
        else $orientation = 'portrait';

        if (Input::has('paper')) $paper = $input['paper'];
        else $paper = 'a4';

        $pdf = App::make('dompdf');
        $html = View::make('programar.pdf.' . $orientation)
            ->with('trabajos', $trabajos)
            ->with('autocontrol', $autocontrol)
            ->with('grupo', $grupo)
            ->with('startOfWeek', $startOfWeek)
            ->with('endOfWeek', $endOfWeek)
            ->with('showObs', $showObs);
        $pdf->loadHTML($html)->setPaper($paper)->setOrientation($orientation); // landscape | portrait
        return $pdf->stream();
    }

    /**
     * @param $input
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function csv($input)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=programa.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
            , 'charset' => 'UTF-8'
        ];

        $weekQuery = Carbon::createFromFormat('d/m/Y', $input['semana'])->toDateString();
        $startOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->startOfWeek()->toDateString();
        $startOfWeek = Carbon::parse($startOfWeek)->format('d/m/Y');
        $endOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->endOfWeek()->toDateString();
        $endOfWeek = Carbon::parse($endOfWeek)->format('d/m/Y');

        $fields = ['trabajo.nombre as Trabajo', 'km_inicio as Km_Inicio', 'Km_termino as Km_Término', 'unidad as Unidad', 'cantidad as Cantidad'];
        Input::has('obs') ? array_push($fields, 'observaciones as Observaciones') : null;

        if (!Input::has('grupo') || $input['grupo'] == 'all') {
            $grupo = null;
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get($fields)
                ->toArray();
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio', 'asc')
                ->get($fields)
                ->toArray();
        } else {
            $grupo = GrupoTrabajo::find($input['grupo']);
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('km_inicio')
                ->get($fields)
                ->toArray();
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', false)
                ->orderBy('trabajo.nombre', 'asc')
                ->orderBy('km_inicio', 'asc')
                ->get($fields)
                ->toArray();
        }

        # add headers for each column in the CSV download
        array_unshift($trabajos, array_keys($trabajos[0]));

        $callback = function () use ($trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo) {
            $FH = fopen('php://output', 'w');
            $header = ['Semana', $startOfWeek . ' al ' . $endOfWeek, 'Grupo', isset($grupo) ? $grupo->base : 'Todos'];
            fputcsv($FH, $header);
            foreach ($trabajos as $row) {
                fputcsv($FH, $row);
            }
            foreach ($autocontrol as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);

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
