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
        $depositos = Deposito::orderBy('nombre')->get(['id', 'nombre']);

        return View::make('reporte.indexDeposito', compact('depositos'));
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
            'fecha_desde'      => 'required|date_format:d/m/Y|before:' . $input['fecha_hasta'],
            'fecha_hasta'      => 'required|date_format:d/m/Y',
            'centro_de_acopio' => 'required|exists:deposito,id'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        $desde = Carbon::createFromFormat('d/m/Y H', $input['fecha_desde'] . '00');
        $hasta = Carbon::createFromFormat('d/m/Y H:i:s', $input['fecha_hasta'] . '23:59:59');

        $deposito = Deposito::findOrFail($input['centro_de_acopio']);

        $colocados = Deposito::join('detalle_material_colocado', 'deposito.id', '=', 'detalle_material_colocado.deposito_id')
            ->join('material', 'detalle_material_colocado.material_id', '=', 'material.id')
            ->join('hoja_diaria', 'detalle_material_colocado.hoja_diaria_id', '=', 'hoja_diaria.id')
            ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
            ->where('deposito.id', '=', $deposito->id)
            ->whereBetween('hoja_diaria.fecha', [ $desde, $hasta ])
            ->orderBy('material.nombre')
            ->get(['hoja_diaria.fecha',
                'deposito.nombre as deposito',
                'material.nombre as material',
                'detalle_material_colocado.cantidad',
                'grupo_trabajo.base as grupo']);

        $retirados = Deposito::join('detalle_material_retirado', 'deposito.id', '=', 'detalle_material_retirado.deposito_id')
            ->join('material_retirado', 'detalle_material_retirado.material_retirado_id', '=', 'material_retirado.id')
            ->join('hoja_diaria', 'detalle_material_retirado.hoja_diaria_id', '=', 'hoja_diaria.id')
            ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
            ->where('deposito.id', '=', $deposito->id)
            ->whereBetween('hoja_diaria.fecha', [ $desde, $hasta ])
            ->orderBy('material_retirado.nombre')
            ->get(['hoja_diaria.fecha',
                'deposito.nombre as deposito',
                'material_retirado.nombre as material',
                'detalle_material_retirado.cantidad',
                'grupo_trabajo.base as grupo']);

        $totalC = 0;
        $totalR = 0;
        foreach ($colocados as $c) {
            $totalC += $c->cantidad;
        }
        foreach ($retirados as $r) {
            $totalR += $r->cantidad;
        }
        Log::debug('Totales', [ 'Colocados' => $totalC, 'Retirados' => $totalR ]);

        return View::make('reporte.resultDeposito')
            ->with('deposito', $deposito)
            ->with('colocados', $colocados)
            ->with('retirados', $retirados);
    }
}