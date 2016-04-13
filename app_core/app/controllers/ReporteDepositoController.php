<?php

use Carbon\Carbon;

class ReporteDepositoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET r/deposito
     *
     * @return Response
     */
    public function index()
    {
        $sectores = Sector::all([ 'id', 'nombre' ]);
        $grupos   = GrupoTrabajo::orderBy('base', 'asc')->get([ 'id', 'base' ]);

        return View::make('reporte.indexDeposito', compact('sectores', 'grupos'));
    }


    /**
     * Show the form for creating a new resource.
     * GET r/deposito/result
     *
     * @return Response
     */
    public function result()
    {
        $input = Input::all();

        $rules = [
            'fecha_desde' => 'required|date_format:d/m/Y|before:' . $input['fecha_hasta'],
            'fecha_hasta' => 'required|date_format:d/m/Y'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input['fecha_desde'] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input['fecha_hasta'] . '23:59:59');

        $sector = $input['sector'] != 'all' ? Sector::findOrFail($input['sector']) : null;
        $block  = $input['block'] != 'all' ? Block::findOrFail($input['block']) : null;
        $grupo  = $input['grupo_via'] != 'all' ? GrupoTrabajo::findOrFail($input['grupo_via']) : null;

        $depositos = Deposito::all([ 'id', 'nombre' ]);

        foreach ($depositos as $deposito) {
            $query = Deposito::join('detalle_material_colocado', 'deposito.id', '=', 'detalle_material_colocado.deposito_id')
                ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
                ->join('hoja_diaria', 'detalle_material_colocado.hoja_diaria_id', '=', 'hoja_diaria.id')
                ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                ->whereBetween('hoja_diaria.fecha', [ $desde, $hasta ])
                ->where('deposito.id', '=', $deposito->id)
                ->groupBy('material.nombre');
            if($block != null){
                $query->where('block.id', '=', $block->id);
            }
            if ($grupo != null) {
                $query->where('grupo_trabajo.id', '=', $grupo->id);
            }
            $deposito->colocados = $query->get([
                'material.nombre as material',
                'detalle_material_colocado.cantidad',
                'grupo_trabajo.base as grupo'
            ]);

            $query = Deposito::join('detalle_material_retirado', 'deposito.id', '=', 'detalle_material_retirado.deposito_id')
                ->join('material_retirado', 'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')
                ->join('hoja_diaria', 'detalle_material_retirado.hoja_diaria_id', '=', 'hoja_diaria.id')
                ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                ->join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                ->whereBetween('hoja_diaria.fecha', [ $desde, $hasta ])
                ->where('deposito.id', '=', $deposito->id)
                ->groupBy('material_retirado.nombre');
            if($block != null){
                $query->where('block.id', '=', $block->id);
            }
            if ($grupo != null) {
                $query->where('grupo_trabajo.id', '=', $grupo->id);
            }
            $deposito->retirados = $query->get([
                'material_retirado.nombre as material',
                'detalle_material_retirado.cantidad',
                'grupo_trabajo.base as grupo'
            ]);
        }

        $colocados = Deposito::join('detalle_material_colocado', 'deposito.id', '=',
            'detalle_material_colocado.deposito_id')->join('material', 'detalle_material_colocado.material_id', '=',
            'material.id')->join('hoja_diaria', 'detalle_material_colocado.hoja_diaria_id', '=',
            'hoja_diaria.id')->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=',
                'grupo_trabajo.id')->whereBetween('hoja_diaria.fecha', [ $desde, $hasta ])->orderBy('material.nombre')->get([
                'deposito.nombre as deposito',
                'material.nombre as material',
                'detalle_material_colocado.cantidad',
            'grupo_trabajo.base as grupo'
            ]);

        $retirados = Deposito::join('detalle_material_retirado', 'deposito.id', '=',
            'detalle_material_retirado.deposito_id')->join('material_retirado',
            'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')->join('hoja_diaria',
            'detalle_material_retirado.hoja_diaria_id', '=', 'hoja_diaria.id')->join('grupo_trabajo',
                'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')->whereBetween('hoja_diaria.fecha',
                [ $desde, $hasta ])->orderBy('material_retirado.nombre')->get([
                'deposito.nombre as deposito',
                'material_retirado.nombre as material',
                'detalle_material_retirado.cantidad',
            'grupo_trabajo.base as grupo'
            ]);

        return View::make('reporte.resultDeposito',
            compact('sector', 'block', 'grupo', 'depositos', 'colocados', 'retirados'));
        //return ['Depositos' => $depositos, 'Colocados' => $colocados, 'Retirados' => $retirados];
    }
}