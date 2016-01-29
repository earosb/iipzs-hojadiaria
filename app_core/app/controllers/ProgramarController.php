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

        $query = Programa::join('trabajo', 'trabajo.id', '=', 'programa.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programa.grupo_trabajo_id');

        if (Input::has('causa'))
            $query->where('programa.causa', 'LIKE', '%' . Input::get('causa') . '%');

        if (Input::has('km_inicio'))
            $query->where('programa.km_inicio', '>=', Input::get('km_inicio'));

        if (Input::has('km_termino'))
            $query->where('programa.km_termino', '<=', Input::get('km_termino'));

        if (Input::has('trabajo_id') && Input::get('trabajo_id') != 'all')
            $query->where('programa.trabajo_id', '=', Input::get('trabajo_id'));

        if (Input::has('realizado') && Input::get('realizado') == 'true')
            $query->where('programa.realizado', true);
        else
            $query->where('programa.realizado', false);

        if (Input::has('semana')) {
            $semana = Carbon::createFromFormat('d/m/Y', Input::get('semana'))->toDateString();
            $query->whereDate('programa.semana', '=', $semana);
            // $query->orWhereNull('programa.semana');
        }

        if (Input::has('vencimiento')) {
            $vencimiento = Carbon::createFromFormat('d/m/Y', Input::get('vencimiento'))->toDateString();
            $query->where('programa.vencimiento', '=', $vencimiento);
            // $query->orWhereNull('programa.vencimiento');
        }

        if (Input::has('grupo_trabajo_id') && Input::get('grupo_trabajo_id') != 'all') {
            $query->where('programa.grupo_trabajo_id', '=', Input::get('grupo_trabajo_id'));
            // $query->orWhereNull('programa.grupo_trabajo_id');
        }

        $trabajos = $query->select('programa.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones', 'obs_ce',
                'grupo_trabajo_id', 'trabajo_id', 'unidad', 'nombre', 'semana', 'no_programable', 'vencimiento', 'realizado',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom')
            ->orderBy('km_inicio')
            ->orderBy('trabajo.nombre', 'asc')
            ->paginate(50);

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
                'grupo_trabajo_id', 'trabajo_id', 'unidad', 'nombre', 'semana', 'vencimiento',
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

    public function merge()
    {
        $trabajos = Input::get('trabajos');

        $trabajo_ids = array();
        $causa = 'merge';
        $cantidad = 0;
        $kmsInicio = array();
        $kmsTermino = array();
        $obs = " Agrupado desde:";

        foreach ($trabajos as $trabajo) {
            array_push($trabajo_ids, $trabajo['trabajo_id']);
            array_push($kmsInicio, $trabajo['km_inicio']);
            array_push($kmsTermino, $trabajo['km_termino']);
            $cantidad = $cantidad + $trabajo['cantidad'];
            $causa = $trabajo['causa'];
            $obs .= "[".$trabajo['nombre'].
            " ".$trabajo['km_inicio'].
            " ".$trabajo['km_termino'].
            " ".$trabajo['cantidad'].
            "]";
        }

        if (count(array_unique($trabajo_ids)) != 1)
            return Response::json(['error' => true, 'msg' => 'Los trabajos seleccionados no son iguales']);

        $new = array(
            'trabajo_id' => $trabajo_ids[0],
            'causa' => $causa,
            'km_inicio' => min($kmsInicio),
            'km_termino' => max($kmsTermino),
            'cantidad' => $cantidad);

        $t = Programa::create($new);
        $t->obs_ce = $t->obs_ce.$obs;
        $t->save();

        $trabajo = DB::table('programa')
            ->join('trabajo', 'trabajo.id', '=', 'programa.trabajo_id')
            ->leftJoin('grupo_trabajo', 'grupo_trabajo.id', '=', 'programa.grupo_trabajo_id')
            ->select('programa.id', 'causa', 'cantidad', 'km_inicio', 'km_termino', 'observaciones', 'obs_ce',
                'grupo_trabajo_id', 'trabajo_id', 'unidad', 'nombre', 'semana', 'vencimiento',
                'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom',
                'grupo_trabajo.id as grupo_trabajo_id')
            ->where('programa.id', '=', $t->id)
            ->first();

        $aux = $trabajo->semana;
        if ($aux) $trabajo->semana = Carbon::parse($aux)->format('d/m/Y');
        $aux2 = $trabajo->vencimiento;
        if ($aux2) $trabajo->vencimiento = Carbon::parse($aux2)->format('d/m/Y');

        return Response::json([
            'error' => false,
            'trabajo' => $trabajo
        ]);
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

        $rules = array(
            'semana' => 'required|date_format:d/m/Y',
            'format' => 'required');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back();
        }

        $weekQuery = Carbon::createFromFormat('d/m/Y', $input['semana'])->toDateString();
        $startOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->startOfWeek()->toDateString();
        $startOfWeek = Carbon::parse($startOfWeek)->format('d/m/Y');
        $endOfWeek = Carbon::createFromFormat('d/m/Y', $input['semana'])->endOfWeek()->toDateString();
        $endOfWeek = Carbon::parse($endOfWeek)->format('d/m/Y');

        $fields = ['trabajo.nombre as Trabajo', 'km_inicio as Km_Inicio', 'Km_termino as Km_Termino', 'unidad as Unidad', 'cantidad as Cantidad',
            'lun', 'mar', 'mie', 'juv', 'vie', 'sab', 'dom'];
        Input::has('obs') ? array_push($fields, 'observaciones as Observaciones') : null;

        $realizados = Input::has('arch') ? true : false;

        if (!Input::has('grupo') || $input['grupo'] == 'all') {
            $grupo = null;
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->whereNotNull('programa.grupo_trabajo_id')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', $realizados)
                ->orderBy('km_inicio')
                ->get($fields);
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->whereNotNull('programa.grupo_trabajo_id')
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', $realizados)
                ->orderBy('km_inicio', 'asc')
                ->get($fields);
        } else {
            $grupo = GrupoTrabajo::find($input['grupo']);
            $trabajos = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '!=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', $realizados)
                ->orderBy('km_inicio')
                ->get($fields);
            $autocontrol = Programa::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
                ->join('tipo_mantenimiento', 'tipo_mantenimiento.id', '=', 'tipo_mantenimiento_id')
                ->where('tipo_mantenimiento.cod', '=', 'autoc')
                ->where('programa.grupo_trabajo_id', '=', $grupo->id)
                ->where('programa.semana', '=', $weekQuery)
                ->where('programa.realizado', $realizados)
                ->orderBy('trabajo.nombre', 'asc')
                ->orderBy('km_inicio', 'asc')
                ->get($fields);
        }

        if ($input['format'] == 'pdf') {
            return $this->pdf($input, $trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo);
        } elseif ($input['format'] == 'csv') {
            return $this->csv($trabajos->toArray(), $autocontrol->toArray(), $startOfWeek, $endOfWeek, $grupo);
        } elseif ($input['format'] == 'excel') {
            return $this->excel($trabajos->toArray(), $autocontrol->toArray(), $startOfWeek, $endOfWeek, $grupo);
        } else {
            return Redirect::back();
        }
    }

    /**
     * @param $input
     * @param $trabajos
     * @param $autocontrol
     * @param $startOfWeek
     * @param $endOfWeek
     * @param $grupo
     * @return Response
     */
    public function pdf($input, $trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo)
    {
        //300 seconds = 5 minutes
        ini_set('max_execution_time', 300);

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
     * @param $trabajos
     * @param $autocontrol
     * @param $startOfWeek
     * @param $endOfWeek
     * @param $grupo
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @internal param $input
     */
    public function csv($trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=programa.txt',
            'Expires' => '0',
            'Pragma' => 'public',
            'Charset' => 'UTF-8'
        ];

        # add headers for each column in the CSV download
        array_unshift($trabajos, array_keys($trabajos[0]));

        $callback = function () use ($trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo) {
            $FH = fopen('php://output', 'w');
            $header = ['Semana', $startOfWeek . ' al ' . $endOfWeek, 'Grupo', isset($grupo) ? $grupo->base : 'Todos'];
            fputcsv($FH, $header);
            foreach ($trabajos as $row) {
                $aux = $this->parseDays($row);
                fputcsv($FH, $aux);
            }
            foreach ($autocontrol as $row) {
                $aux = $this->parseDays($row);
                fputcsv($FH, $aux);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);

    }

    /**
     * @param $trabajos
     * @param $autocontrol
     * @param $startOfWeek
     * @param $endOfWeek
     * @param $grupo
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @internal param $input
     */
    public function excel($trabajos, $autocontrol, $startOfWeek, $endOfWeek, $grupo)
    {
        $grupo = isset($grupo) ? $grupo->base : 'Todos';

        foreach ($trabajos as $key => $row) {
            $trabajos[$key] = $this->parseDays($row);
        }
        foreach ($autocontrol as $key => $row) {
            $autocontrol[$key] = $this->parseDays($row);
        }

        Excel::create('Programa ' . $startOfWeek . ' al ' . $endOfWeek, function ($excel) use ($grupo, $trabajos, $autocontrol) {
            $excel->sheet('Grupo_' . $grupo, function ($sheet) use ($trabajos, $autocontrol) {
                //$sheet->fromArray($header);
                $sheet->fromArray($trabajos);
                $sheet->fromArray($autocontrol);
            });
        })->export('xls');

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

    /**
     * Transforma los dias de semana
     * 'Checked' a x y el resto en blanco
     * @param $row
     * @return mixed
     */
    private function parseDays($row)
    {
        if (isset($row['lun']) && $row['lun'] == 'checked')
            $row['lun'] = 'x';
        else
            $row['lun'] = null;
        if (isset($row['mar']) && $row['mar'] == 'checked')
            $row['mar'] = 'x';
        else
            $row['mar'] = null;
        if (isset($row['mie']) && $row['mie'] == 'checked')
            $row['mie'] = 'x';
        else
            $row['mie'] = null;
        if (isset($row['juv']) && $row['juv'] == 'checked')
            $row['juv'] = 'x';
        else
            $row['juv'] = null;
        if (isset($row['vie']) && $row['vie'] == 'checked')
            $row['vie'] = 'x';
        else
            $row['vie'] = null;
        if (isset($row['sab']) && $row['sab'] == 'checked')
            $row['sab'] = 'x';
        else
            $row['sab'] = null;
        if (isset($row['dom']) && $row['dom'] == 'checked')
            $row['dom'] = 'x';
        else
            $row['dom'] = null;

        return $row;
    }
}
