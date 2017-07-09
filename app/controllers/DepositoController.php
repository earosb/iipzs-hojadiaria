<?php

use Carbon\Carbon;

class DepositoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /deposito
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $depositos = Deposito::orderBy('nombre')->get(['id', 'nombre']);

        return View::make('deposito.index', compact('depositos'));
    }


    /**
     * Show the form for creating a new resource.
     * GET /deposito/create
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('deposito.create');
    }


    /**
     * GET /deposito/id
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function show($id)
    {
        $deposito = Deposito::findOrFail($id);
        $cargas = Carga::join('material', 'material.id', '=', 'material_id')
            ->where('deposito_id', '=', $deposito->id)
            ->orderBy('carga.fecha', 'desc')
            ->get([
                'carga.fecha',
                'carga.cantidad',
                'carga.obs',
                'material.nombre as material'
            ]);

        $html = View::make('deposito.show', compact('deposito', 'cargas'))->render();
        if (Request::ajax()) {
            return Response::json(['html' => $html]);
        }

        return App::abort(404);
    }


    /**
     * Store a newly created resource in storage.
     * POST /deposito
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, Deposito::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Deposito::create($input);

        return Redirect::to('m/deposito');
    }


    /**
     * Show the form for editing the specified resource.
     * GET /deposito/{id}/edit
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $deposito = Deposito::find($id);

        return View::make('deposito.edit', compact('deposito'));
    }


    /**
     * Update the specified resource in storage.
     * PUT /deposito/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $input = Input::all();

        $validator = Validator::make($input, Deposito::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Deposito::find($id)->update($input);

        return Redirect::to('m/deposito');
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /deposito/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Deposito::destroy($id);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'msg' => $e->getMessage()
            ]);
        }

        return Response::json(['error' => false]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showHistory()
    {
        $query = DB::table('deposito_historico_colocados_view');

        $paginate = (Input::has('paginate') ? Input::get('paginate') : 20);

        if (Input::has('material')) {
            $query->where('material', '=', Input::get('material'));
        }

        if (Input::has('acopio')) {
            $query->where('acopio_id', '=', Input::get('acopio'));
        }

        if (Input::has('material') && Input::has('acopio')) $total = true;
        else $total = false;

        $results = $query->get(); //paginate($paginate);

        $subTotal = 0;
        $result = [];
        foreach (array_reverse($results) as $item) {
            if ($item->tipo === 'egreso hd')
                $subTotal += $item->cantidad;
            elseif ($item->tipo === 'ingreso hd')
                $subTotal -= $item->cantidad;
            elseif ($item->tipo === 'carga')
                $subTotal += $item->cantidad;

            $result[] = [
                'fecha' => $item->fecha,
                'tipo' => $item->tipo,
                'cantidad' => $item->cantidad,
                'material' => $item->material,
                'acopio' => $item->acopio,
                'total' => $subTotal,
            ];
        }

        $result = array_reverse($result);

        $year = Carbon::today()->year;

        $materiales = Material::all();
        $materialesRet = MaterialRetirado::all();
        $depositos = Deposito::orderBy('nombre')->get(['id', 'nombre']);
//        $results->appends(Input::except('page'));


        return View::make('deposito.history', compact('result', 'results', 'year', 'materiales', 'materialesRet', 'depositos', 'total'));
    }

    public function formReporte(){
        $depositos = Deposito::orderBy('nombre')->get([ 'id', 'nombre' ]);

        $colocados = Material::orderBy('nombre')->get([ 'id', 'nombre' ]);

        $retirados = MaterialRetirado::orderBy('nombre')->get([ 'id', 'nombre' ]);

        return View::make('deposito.formReporte', compact('depositos', 'colocados', 'retirados'));
    }

    public function getReporte(){

        $validator = Validator::make(Input::all(), [
            'fecha_hasta' => 'required',
            'material'    => 'required',
            'acopio'      => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $date = Carbon::createFromFormat('d/m/Y', Input::get('fecha_hasta'))->toDateString();

        $materialInput = explode('.', Input::get('material'));

        if ($materialInput[0] === 'c'){
            $table = 'deposito_historico_colocados_view';
            $material = Material::find($materialInput[1])->nombre;
        }else{
            $table = 'deposito_historico_retirados_view';
            $material = MaterialRetirado::find($materialInput[1])->nombre;
        }

        $items = DB::table($table)
            ->where('material_id', '=', $materialInput[1])
            ->where('acopio_id', '=', Input::get('acopio'))
            ->where('fecha', '<=', $date)
            ->orderBy('fecha', 'ASC')->get(); //->paginate(20);

        $acopio = Deposito::find(Input::get('acopio'))->nombre;

        return View::make('deposito.reporte')
            ->with('items', $items)
            ->with('fecha', Input::get('fecha_hasta'))
            ->with('material', $material)
            ->with('acopio', $acopio);
    }

}