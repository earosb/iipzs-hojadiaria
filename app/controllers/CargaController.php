<?php

use Carbon\Carbon;

class CargaController extends \BaseController
{

    /**
     * Display a listing of cargas
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cargas = Carga::paginate(20);

        return View::make('carga.index', compact('cargas'));
    }


    /**
     * Show the form for creating a new carga
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (Input::has('d')) {
            $deposito   = Deposito::find(Input::get('d'));
            $materiales = Material::orderBy('nombre')->get([ 'id', 'nombre' ]);

            $html = View::make('carga.create', compact('deposito', 'materiales'))->render();

            return Response::json([ 'html' => $html ]);
        }

        $depositos   = Deposito::orderBy('nombre')->get([ 'id', 'nombre' ]);
        $materiales = Material::orderBy('nombre')->get([ 'id', 'nombre' ]);

        return View::make('carga.create', compact('depositos', 'materiales'));
    }


    /**
     * Store a newly created carga in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Carga::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        }

        $dateFlag = Carbon::createFromFormat('Y-m-d', $data['fecha']); //'d/m/Y'

        $carga = new Carga();
        $carga->tipo = $data['tipo'];
        $carga->cantidad = $data['cantidad'];
        $carga->fecha = $dateFlag->toDateString();
        $carga->obs = $data['obs'];
        $carga->deposito_id = $data['deposito'];
        $carga->material_id = $data['material'];
        $carga->save();

        Alert::message('Carga ingresada con éxito', 'success');
        return Redirect::to('carga/create');
    }


    /**
     * Remove the specified material from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Carga::destroy($id);
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => $e->getMessage()));
        }
        return Response::json(array('error' => false));
    }

}
