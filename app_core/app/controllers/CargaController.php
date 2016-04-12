<?php

use Carbon\Carbon;

class CargaController extends \BaseController
{

    /**
     * Display a listing of cargas
     *
     * @return Response
     */
    public function index()
    {
        $cargas = Carga::all();

        return View::make('cargas.index', compact('cargas'));
    }


    /**
     * Show the form for creating a new carga
     *
     * @return Response
     */
    public function create()
    {
        if (Input::has('d')) {
            $deposito   = Deposito::find(Input::get('d'));
            $materiales = Material::orderBy('nombre')->get([ 'id', 'nombre' ]);

            $html = View::make('carga.create', compact('deposito', 'materiales'))->render();

            return Response::json([ 'html' => $html ]);
        }

        return Response::json([ 'html' => '<h4>Error en depósito</h4>' ]);
        //return View::make('cargas.create');
    }


    /**
     * Store a newly created carga in storage.
     *
     * @return Response
     */
    public function store()
    {
        Log::debug('FORM', [Input::all()]);

        $validator = Validator::make($data = Input::all(), Carga::$rules);

        if ($validator->fails()) {
            Alert::message($validator->errors()->first(), 'danger');
            return Redirect::to('m/deposito');
        }

        $dateFlag = Carbon::createFromFormat('Y-m-d', $data['fecha']); //'d/m/Y'

        $carga = new Carga();
        $carga->alias = $data['alias'];
        $carga->fecha = $dateFlag->toDateString();
        $carga->total = $data['total'];
        $carga->restante = $data['total'];
        $carga->deposito_id = $data['deposito_id'];
        $carga->material_id = $data['material_id'];
        $carga->save();

        Alert::message('Carga ingresada con éxito', 'success');
        return Redirect::to('m/deposito');
    }


    /**
     * Display the specified carga.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carga = Carga::findOrFail($id);

        return View::make('cargas.show', compact('carga'));
    }


    /**
     * Show the form for editing the specified carga.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carga = Carga::find($id);

        return View::make('cargas.edit', compact('carga'));
    }


    /**
     * Update the specified carga in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $carga = Carga::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Carga::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $carga->update($data);

        return Redirect::route('cargas.index');
    }


    /**
     * Remove the specified carga from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Carga::destroy($id);

        return Redirect::route('cargas.index');
    }

}
