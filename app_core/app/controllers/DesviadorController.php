<?php

class DesviadorController extends \BaseController
{

    /**
     * Guarda un nuevo Desviador
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxCreate()
    {
        $input = array(
            '_token'                => Input::get('_token'),
            'nombre'                => Input::get('nombre'),
            'km_inicio'             => Input::get('km_inicio'),
            'selectsectorDesviador' => Input::get('selectsectorDesviador'),
            'selectblockDesviador'  => Input::get('selectblockDesviador'),
        );
        /**
         * Valida que el block sea mayor que cero antes de sonsultar si existe
         */
        if ($input['selectblockDesviador'] <= 0) {
            return Response::json(array(
                                      'fail'   => true,
                                      'errors' => array(
                                          'selectblockDesviador' => array('Debe seleccionar un Block'))
                                  ));
        }

        $block = Block::findOrFail($input['selectblockDesviador']);

        $rules = array(
            'nombre'                => 'required',
            'km_inicio'             => 'required|numeric|between:' . $block->km_inicio . ',' . $block->km_termino,
            'selectsectorDesviador' => 'required|numeric',
            'selectblockDesviador'  => 'required|numeric',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                                      'error'   => true,
                                      'msg' => $validator->messages()
                                  ));
        } else {
            // Crea el obj Desviador y lo guarda
            $desviador = new Desviador;

            $desviador->nombre = $input['nombre'];
            $desviador->km_inicio = $input['km_inicio'];
            $desviador->block_id = $input['selectblockDesviador'];

            $desviador->save();

            return Response::json(array(
                                      'error' => false,
                                      'msg'   => 'Nuevo Desviador creado con éxito'
                                  ));
        }
    }

    /**
     * Retorna los desviadores al sur
     * @param $idNorte
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDesviadoresSur($idNorte)
    {
        try {
            $norte = Desviador::find($idNorte);
            $desviadores = Desviador::where('block_id', '=', $norte->block_id)
                ->where('km_inicio', '>', $norte->km_inicio)
                ->get();
            if ($desviadores->isEmpty()) {
                return Response::json(array(
                                          'error' => true,
                                          'msg'   => 'El Desviador seleccionado no tiene Desviadores hacia el Sur'
                                      ));
            }
            return Response::json(array(
                                      'error'       => false,
                                      'desviadores' => $desviadores
                                  ));
        } catch (\Exception $e) {
            return Response::json(array(
                                      'error' => true,
                                      'msg'   => 'Desviador no encontrado'
                                  ));
        }

    }


}