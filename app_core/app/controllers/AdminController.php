<?php

class AdminController extends \BaseController
{
    /**
     * Para testear algo...
     * GET /admin/test
     *
     * @return Response
     */
    public function test()
    {
        $sector = Sector::find(1);
        $year = 2015;
        $mes = 5;
        $tipoTrabajo = 'mayor';

        $desdeQuery = date('Y-m-01', strtotime($year . '-' . $mes . '-01'));
        $hastaQuery = date('Y-m-t', strtotime($year . '-' . $mes . '-01'));

        $blocks = $sector->blocks;

        $trabajosMeta['sector'] = $sector->nombre;
        $trabajosMeta['fecha'] = $mes . ' - ' . $year;

        $partidas = Trabajo::where('trabajo.es_oficial', '=', '1', 'and')
            ->where('tipo_mantenimiento.cod', '=', $tipoTrabajo)
            ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
            ->select('trabajo.id', 'trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
            ->get();

        foreach ($partidas as $partida) {
            $trabajos = array();
            $trabajosMeta['nombre'] = $partida->nombre;
            foreach ($blocks as $block) {
                $trabajosQuery = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array($desdeQuery, $hastaQuery), 'and')
                    ->where('block.id', '=', $block->id)
                    ->where('trabajo.id', '=', $partida->id)
                    ->select(
                        array(
                            'block.id',
                            'block.estacion',
                            'detalle_hoja_diaria.km_inicio',
                            'detalle_hoja_diaria.km_termino',
                            'detalle_hoja_diaria.desviador_id',
                            'detalle_hoja_diaria.desvio_id',
                            'trabajo.nombre',
                            'trabajo.unidad',
                            'detalle_hoja_diaria.cantidad'))
                    ->orderBy('detalle_hoja_diaria.km_inicio')
                    ->get();
                if (!$trabajosQuery->isEmpty()) {
                    $trabajos[] = $trabajosQuery;
                    $trabajosMeta['block'][] = $block->estacion;
                }
            }
            if (!empty($trabajos)) {
                Excel::create($trabajosMeta['nombre'], function ($excel) use ($trabajosMeta, $trabajos) {
                    foreach ($trabajos as $index => $t) {
                        $trabajosMeta['total'] = 0;
                        foreach ($t as $cont => $aux) {
                            $trabajosMeta['total'] += $aux->cantidad;
                        }

                        $excel->sheet($trabajosMeta['block'][$index], function ($sheet) use ($trabajosMeta, $t, $index) {
                            $sheet->setStyle(array('font' => array('name' => 'Arial', 'size' => 12)));
                            $sheet->setAutoSize(true);
                            $sheet->loadView('reporte.generador')
                                ->with('block', $trabajosMeta['block'][$index])
                                ->with('trabajosMeta', $trabajosMeta)
                                ->with('trabajos', $t);
                        });
                    }
                })->store('xls', public_path('excel/test'));
            }
            unset($trabajos);
        }
        return 'done';
    }

    /**
     * Refactor campo tipo_via en tabla detalle_hoja_diaria.
     * GET /admin/refactor_dhd/tipo_via
     *
     * @return Response
     */
    public function RefactorDHDTipoVia()
    {
        $trabajos = DetalleHojaDiaria::all(['block_id', 'desviador_id', 'desvio_id', 'tipo_via']);

        foreach ($trabajos as $trabajo) {
            if ($trabajo->desviador_id == null && $trabajo->desvio_id == null) {
                $trabajo->tipo_via = 'LP';
            } else {
                if ($trabajo->desviador_id != null) {
                    $desviador = Desviador::find($trabajo->desviador_id);
                    $trabajo->tipo_via = $desviador->nombre;
                } elseif ($trabajo->desvio_id != null) {
                    $desvio = Desvio::find($trabajo->desvio_id);
                    $trabajo->tipo_via = $desvio->nombre;
                }
            }
            $trabajo->save();
            Log::debug($trabajo);
        }
        Alert::message('RefactorDHDTipoVia(), Listoco!', 'success');
        return View::make('home');
    }

}