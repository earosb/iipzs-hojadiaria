<?php

use Carbon\Carbon;

class HojaDiariaController extends \BaseController
{

    /**
     * Show the form for creating a new resource.
     * GET /hd/create
     *
     * @return Response
     */
    public function create()
    {
        $sectores = Sector::all(array( 'id', 'nombre' ));

        $tipoMantenimiento = TipoMantenimiento::All(array( 'id', 'nombre' ));
        foreach ( $tipoMantenimiento as $tMat ) {
            $tMat->trabajos;
        }

        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get(array( 'id', 'base' ));

        $materialesCollection = Material::all(array( 'id', 'nombre', 'unidad' ));
        $materiales = array();
        foreach ( $materialesCollection as $material ) {
            $materiales[ $material->id ] = $material->nombre.' ('.$material->unidad.')';
        }

        $matRetCollection = MaterialRetirado::all(array( 'id', 'nombre' ));
        $matRetirados = array();
        foreach ( $matRetCollection as $matRet ) {
            $matRetirados[ $matRet->id ] = $matRet->nombre;
        }

        return View::make('hoja_diaria.create')
            ->with('sectores', $sectores)
            ->with('grupos', $grupos)
            ->with('materiales', $materiales)
            ->with('materialesRet', $matRetirados)
            ->with('tipoMantenimiento', $tipoMantenimiento);
    }

    /**
     * Display a listing of the resource.
     * GET /hd
     *
     * @return Response
     */
    public function index()
    {
        $hojasCollection = HojaDiaria::join('users', 'hoja_diaria.user_id', '=', 'users.id')
            ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
            ->orderBy('hoja_diaria.fecha')
            ->get(array('hoja_diaria.id', 'hoja_diaria.fecha', 'hoja_diaria.created_at', 'hoja_diaria.updated_at', 'users.username', 'grupo_trabajo.base'));


        return View::make('hoja_diaria.index')
            ->with('hojas', $hojasCollection);
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
        $input = Input::except('trabajos.0', 'matCol.0', 'matRet.0');
        /**
         * reglas de validación
         * @var array
         */
        $rules = array(
            'fecha'        => 'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' => 'required|exists:sector,id',
            'selectblock'  => 'required|exists:block,id,sector_id,' . $input[ 'selectsector' ],
            'selectgrupos' => 'required|exists:grupo_trabajo,id',
        );
        /**
         * agrega reglas de validación si es que existen campos
         * @var [type]
         */
        foreach ( $input[ 'trabajos' ] as $key => $value ) {
            // explode() simil de función split()
            list($tipo, $id) = explode('-', $value[ 'ubicacion' ]);
            switch ( $tipo ) {
                case 'block':
                    $block                                       = Block::find($id);
                    $min                                         = $block->km_inicio;
                    $max                                         = $block->km_termino;
                    $rules[ 'trabajos.' . $key . '.km_inicio' ]  = 'required|numeric|between:' . $min . ',' . $value[ 'km_termino' ];
                    $rules[ 'trabajos.' . $key . '.km_termino' ] = 'required|numeric|between:' . $value[ 'km_inicio' ] . ',' . $max;
                    break;
                case 'desvio':
                    $desvio                                     = Desvio::find($id);
                    $min                                        = $desvio->block->km_inicio;
                    $max                                        = $desvio->block->km_termino;
                    $rules[ 'trabajos.' . $key . '.km_inicio' ] = 'required|numeric|between:' . $min . ',' . $max;
                    break;
                case 'desviador':
                    $desviador = Desviador::find($id);
                    $min       = $desviador->km_inicio;
                    // Rango de 100 mts a cada lado por si las moscas los viejos ponen datos malos, en teoría debería ser un km exacto
                    $rules[ 'trabajos.' . $key . '.km_inicio' ] = 'required|numeric|between:' . ($min - 100) . ',' . ($min + 100);
                    break;
            }
            $rules[ 'trabajos.' . $key . '.ubicacion' ] = 'required';
            $rules[ 'trabajos.' . $key . '.trabajo' ]   = 'required|exists:trabajo,id';
            $rules[ 'trabajos.' . $key . '.cantidad' ]  = 'required|numeric|min:0';

        }
        foreach ( $input[ 'matCol' ] as $key => $value ) {
            $rules[ 'matCol.' . $key . '.id' ]   = 'required|exists:material,id';
            $rules[ 'matCol.' . $key . '.cant' ] = 'required|numeric|min:0';
        }
        foreach ( $input[ 'matRet' ] as $key => $value ) {
            $rules[ 'matRet.' . $key . '.id' ]   = 'required|exists:material_retirado,id';
            $rules[ 'matRet.' . $key . '.cant' ] = 'required|numeric|min:0';
        }
        /**
         * lleva la validación acabo
         * @var [type]
         */
        $validator = Validator::make($input, $rules);

        if ( $validator->fails() ) {
            return Response::json(
                array(
                    'error' => true,
                    'msg'   => $validator->messages()
                ));
        }

        /**
         * Sin errores, listo para guardar
         */
        $dateFlag = Carbon::createFromFormat('d/m/Y', $input[ 'fecha' ]);

        $hojaDiaria                   = new HojaDiaria();
        $hojaDiaria->fecha            = $dateFlag->toDateString();
        $hojaDiaria->observaciones    = $input[ 'obs' ];
        $hojaDiaria->grupo_trabajo_id = $input[ 'selectgrupos' ];
        $hojaDiaria->user_id = Sentry::getUser()->id;

        $hojaDiaria->save();

        foreach ( $input[ 'trabajos' ] as $key => $value ) {
            list($tipo, $id) = explode('-', $value[ 'ubicacion' ]);

            $trabajo = Trabajo::find($value[ 'trabajo' ]);

            $detHojaDiaria                 = new DetalleHojaDiaria();
            $detHojaDiaria->trabajo_id     = $trabajo->id;
            $detHojaDiaria->cantidad       = $value[ 'cantidad' ];
            $detHojaDiaria->hoja_diaria_id = $hojaDiaria->id;
            switch ( $tipo ) {
                case 'block':
                    $block                     = Block::find($id);
                    $detHojaDiaria->block_id   = $block->id;
                    $detHojaDiaria->km_inicio  = $value[ 'km_inicio' ];
                    $detHojaDiaria->km_termino = $value[ 'km_termino' ];
                    break;
                case 'desvio':
                    $desvio                    = Desvio::find($id);
                    $detHojaDiaria->block_id   = $desvio->block->id;
                    $detHojaDiaria->desvio_id  = $desvio->id;
                    $detHojaDiaria->km_inicio  = $value[ 'km_inicio' ];
                    $detHojaDiaria->km_termino = $value[ 'km_termino' ];
                    break;
                case 'desviador':
                    $desviador                   = Desviador::find($id);
                    $detHojaDiaria->block_id     = $desviador->block->id;
                    $detHojaDiaria->desviador_id = $desviador->id;
                    $detHojaDiaria->km_inicio    = $desviador->km_inicio;
                    break;
            }
            $detHojaDiaria->save();
        }

        foreach ( $input[ 'matCol' ] as $key => $value ) {
            $material = Material::find($value[ 'id' ]);

            $detMatCol                 = new DetalleMaterialColocado();
            $detMatCol->cantidad       = $value[ 'cant' ];
            $detMatCol->reempleo       = (array_key_exists('reempleo', $value)) ? true : false;
            $detMatCol->material_id    = $material->id;
            $detMatCol->hoja_diaria_id = $hojaDiaria->id;

            $detMatCol->save();
        }

        foreach ( $input[ 'matRet' ] as $key => $value ) {
            $matRet = MaterialRetirado::find($value[ 'id' ]);

            $detMatRet                       = new DetalleMaterialRetirado();
            $detMatRet->cantidad             = $value[ 'cant' ];
            $detMatRet->reempleo             = (array_key_exists('reempleo', $value)) ? true : false;
            $detMatRet->material_retirado_id = $matRet->id;
            $detMatRet->hoja_diaria_id       = $hojaDiaria->id;

            $detMatRet->save();
        }

        return Response::json(
            array(
                'error' => false,
                'msg'   => 'Hoja Diaria creada con éxito'
            ));

    }

    /**
     * Display the specified resource.
     * GET /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $hojaDiaria = HojaDiaria::find($id);
        } catch ( \Exception $e ) {
            return Response::json(
                array(
                    'error' => true,
                    'msg'   => 'La hoja diaria seleccionada no fue encontrada'
                ));
        }

        $hojaDiaria->fecha = Carbon::parse($hojaDiaria->fecha)->format('d-m-Y');

        $hojaDiaria->grupoTrabajo;

        $hojaDiaria->detalleMaterialRetirado;
        foreach ( $hojaDiaria->detalleMaterialRetirado as $materialRet ) {
            $materialRet->materialRetirado;
        }

        $hojaDiaria->detalleMaterialColocado;
        foreach ( $hojaDiaria->detalleMaterialColocado as $materialCol ) {
            $materialCol->material;
        }

        $hojaDiaria->detalleHojaDiaria;
        foreach ( $hojaDiaria->detalleHojaDiaria as $trabajo ) {
            $trabajo->trabajo;
            $trabajo->block;
            $trabajo->desvio;
            $trabajo->desviador;
        }

        return Response::json(
            array(
                'error'      => false,
                'hojaDiaria' => $hojaDiaria,
            ));

    }

    /**
     * Show the form for editing the specified resource.
     * GET /hd/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        App::abort(404);
    }

    /**
     * Update the specified resource in storage.
     * PUT /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        App::abort(404);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $hojaDiaria = HojaDiaria::find($id);

            $hojaDiaria->detalleHojaDiaria()->forceDelete();
            $hojaDiaria->detalleMaterialColocado()->forceDelete();
            $hojaDiaria->detalleMaterialRetirado()->forceDelete();
            $hojaDiaria->forceDelete();

            return Response::json(array( 'error' => false, ));

        } catch ( \Exception $e ) {
            return Response::json(
                array(
                    'error' => true,
                    'msg'   => 'Ocurrió un error al intentar eliminar la hoja diaria',
                ));
        }
    }

}
