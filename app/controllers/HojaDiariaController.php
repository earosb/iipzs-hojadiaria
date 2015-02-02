<?php

class HojaDiariaController extends \BaseController {

    /**
    * Display a listing of the resource.
    * GET /hd
    *
    * @return Response
    */
    public function index()
    {
        //
    }

    /**
    * Show the form for creating a new resource.
    * GET /hd/create
    *
    * @return Response
    */
    public function create()
    {
        $sectores = Sector::all(array('id','nombre'));

        $trabajos = Trabajo::all();
        $trabajosArray = array();
        foreach ($trabajos as $trabajo) {
            if (!$trabajo->materiales() != null) { //   ESTO NO FUNCIONA :(
                foreach ($trabajo->materiales as $material) {
                    $trabajosArray[$trabajo->id] = $trabajo->nombre." [".$material->unidad."]";
                }
            }else{
                $trabajosArray[$trabajo->id] = $trabajo->nombre;
            }
        }

        $grupos = GrupoTrabajo::all(array('id','base'));

        $materialesAll = Material::all(array('id','nombre'));
        foreach ($materialesAll as $material) {
            $materiales[$material->id] = $material->nombre;
        }

        $matRetAll = MaterialRetirado::all(array('id', 'nombre'));
        foreach ($matRetAll as $matRet) {
            $matRetirados[$matRet->id] = $matRet->nombre;
        }

        return View::make('hoja_diaria.create')
            ->with('sectores', $sectores)
            ->with('trabajos', $trabajosArray)
            ->with('grupos', $grupos)
            ->with('materiales', $materiales)
            ->with('materialesRet', $matRetirados);
    }

    /**
    * Store a newly created resource in storage.
    * El formulario se valida en dos partes!
    * POST /hojadiaria
    *
    * @return Response
    */
    public function store()
    {
        /**
        * extrae todos los campos excepto los ocultos en el formulario
        */
        $input = Input::except('trabajos.0','matCol.0','matRet.0');
        /**
         * reglas de validación
         * @var array
         */
        $rules = array(
            'fecha'        =>   'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' =>   'required|exists:sector,id',
            'selectblock'  =>   'required|exists:block,id,sector_id,'.$input['selectsector'],
            'selectgrupos' =>   'required|exists:grupo_trabajo,id',
        );
        /**
         * agrega reglas de validación si es que existen campos
         * @var [type]
         */
        foreach ($input['trabajos'] as $key => $value) {
            // explode() simil de función split()
            list($tipo, $id) = explode('-', $value['ubicacion']);
            switch ($tipo) {
                case 'block':
                    $block = Block::find($id);
                    $min = $block->km_inicio;
                    $max = $block->km_termino;
                    $rules['trabajos.'.$key.'.km_inicio'] = 'required|numeric|between:'.$min.','.$max;
                    $rules['trabajos.'.$key.'.km_termino'] = 'required|numeric|between:'.$min.','.$max;
                    break;
                case 'desvio':
                    $desvio = Desvio::find($id);
                    $min = $desvio->block->km_inicio;
                    $max = $desvio->block->km_termino;
                    $rules['trabajos.'.$key.'.km_inicio'] = 'required|numeric|between:'.$min.','.$max;
                    break;
                case 'desviador':
                    $desviador = Desviador::find($id);
                    $min = $desviador->km_inicio;
                    $max = $desviador->block->km_termino;
                    $rules['trabajos.'.$key.'.km_inicio'] = 'required|numeric|between:'.$min.','.$max;
                    $rules['trabajos.'.$key.'.km_termino'] = 'required|numeric|between:'.$min.','.$max;
                    break;
            }
            $rules['trabajos.'.$key.'.trabajo'] = 'required|exists:trabajo,id';
            $rules['trabajos.'.$key.'.ubicacion'] = 'required';//|exists:'.$tipo.','.$id;
            $rules['trabajos.'.$key.'.cantidad'] = 'required|numeric';
            
        }
        foreach ($input['matCol'] as $key => $value) {
            $rules['matCol.'.$key.'.id'] = 'required|exists:material,id';
            $rules['matCol.'.$key.'.cant'] = 'required|numeric';
        }
        foreach ($input['matRet'] as $key => $value) {
            $rules['matRet.'.$key.'.id'] = 'required|exists:material_retirado,id';
            $rules['matRet.'.$key.'.cant'] = 'required|numeric';
        }
        /**
         * lleva la validación acabo
         * @var [type]
         */
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'fail'   => true,
                'errors' => $validator->messages()
            ));
        }

        return Response::json(array(
                'fail'   => false,
                'input'  => $input,
                'rules'  => $rules,
                'validator'  => $validator,
        ));
        
    }

    /**
    * Display the specified resource.
    * GET /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
        return 'show id hoja diaria '.$id;
    }

    /**
    * Show the form for editing the specified resource.
    * GET /hd/{id}/edit
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    * PUT /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    * DELETE /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        //
    }

}
