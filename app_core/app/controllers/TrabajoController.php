<?php

/**
 *
 * @author earosb
 */
class TrabajoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /trabajo
     *
     * @return Response
     */
    public function index()
    {
        $trabajos = TipoMantenimiento::join('trabajo', 'tipo_mantenimiento.id', '=', 'trabajo.tipo_mantenimiento_id')
            ->select('tipo_mantenimiento.nombre as mantenimiento', 'trabajo.nombre', 'trabajo.valor', 'trabajo.unidad', 'trabajo.es_oficial', 'trabajo.id')
            //->groupBy('tipo_mantenimiento.id')
            ->get();
        //$trabajos = Trabajo::all();

        return View::make('trabajo.index', compact('trabajos'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /trabajo/create
     *
     * @return Response
     */
    public function create()
    {
        $tipoMantenimiento = TipoMantenimiento::All(array('id', 'nombre'));
        $materiales = Material::all(array('id', 'nombre'));

        return View::make('trabajo.create')
            ->with('tipoMantenimiento', $tipoMantenimiento)
            ->with('materiales', $materiales);
    }

    /**
     * Store a newly created resource in storage.
     * POST /trabajo
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $rules = array(
            'nombre' => 'required',
            'padre' => ($input['padre'] != 'none') ? 'required|exists:trabajo,id' : 'required',
            'valor' => 'required|numeric|min:0',
            'unidad' => 'required',
            'tMat' => 'required|exists:tipo_mantenimiento,id',
        );

        if (isset($input['materiales'])) {
            foreach ($input['materiales'] as $mId) {
                $rules['materiales.' . $mId] = 'required|exists:material,id';
            }
        }

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(
                    array('error' => true, 'msg' => $validator->messages()));
            }
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $trabajo = new Trabajo();

        $trabajo->nombre = $input['nombre'];
        $trabajo->valor = $input['valor'];
        $trabajo->unidad = $input['unidad'];
        $trabajo->es_oficial = isset($input['es_oficial']) ? true : false;
        $trabajo->tipo_mantenimiento_id = $input['tMat'];
        $trabajo->padre_id = ($input['padre'] != 'none') ? $input['padre'] : null;

        $trabajo->save();

        if (isset($input['materiales'])) {
            foreach ($input['materiales'] as $cont => $m) {
                $trabajoMaterial = new TrabajoMaterial();
                $trabajoMaterial->trabajo_id = $trabajo->id;
                $trabajoMaterial->material_id = $cont;
                $trabajoMaterial->save();
            }
        }

        if (Request::ajax()) {
            return Response::json(array(
                'error' => false,
                'trabajo' => $trabajo,
                'msg' => 'Nuevo Trabajo creado con éxito'
            ));
        }

        return Redirect::route('m.trabajo.index');
    }

    /**
     * Display the specified resource.
     * GET /trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        App::abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /trabajo/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $trabajo = Trabajo::find($id);
        $trabajo->trabajoMaterial;
        $materiales = Material::all(array('id', 'nombre'));
        // $materiales = Material::join('trabajo_material', 'material.id', '=', 'trabajo_material.material_id');
        $tipoMantenimiento = TipoMantenimiento::All(array('id', 'nombre'));
        return View::make('trabajo.edit')
            ->with('trabajo', $trabajo)
            ->with('materiales', $materiales)
            ->with('tipoMantenimiento', $tipoMantenimiento);
    }

    /**
     * Update the specified resource in storage.
     * PUT /trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $trabajo = Trabajo::find($id);

        $input = Input::all();

        $rules = array(
            'nombre' => 'required',
            'padre' => ($input['padre'] != 'none') ? 'required|exists:trabajo,id' : 'required',
            'valor' => 'required|numeric|min:0',
            'unidad' => 'required',
            'tMat' => 'required|exists:tipo_mantenimiento,id',
        );

        if (isset($input['materiales'])) {
            foreach ($input['materiales'] as $mId) {
                $rules['materiales.' . $mId] = 'required|exists:material,id';
            }
        }

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }

        $trabajo->nombre = $input['nombre'];
        $trabajo->valor = $input['valor'];
        $trabajo->unidad = $input['unidad'];
        $trabajo->es_oficial = isset($input['es_oficial']) ? true : false;
        $trabajo->tipo_mantenimiento_id = $input['tMat'];
        $trabajo->padre_id = ($input['padre'] != 'none') ? $input['padre'] : null;

        $trabajo->save();

        $trabajo->trabajoMaterial()->forceDelete();

        if (isset($input['materiales'])) {
            foreach ($input['materiales'] as $cont => $m) {
                $trabajoMaterial = new TrabajoMaterial();
                $trabajoMaterial->trabajo_id = $trabajo->id;
                $trabajoMaterial->material_id = $cont;
                $trabajoMaterial->save();
            }
        }

        return Redirect::route('m.trabajo.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $trabajo = Trabajo::find($id);
        $trabajo->trabajoMaterial()->forceDelete();
        $trabajo->forceDelete();

        return Response::json(array('error' => false));
    }

}