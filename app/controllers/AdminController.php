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

    }

    /**
     * Refactor campo tipo_via en tabla detalle_hoja_diaria.
     * GET /admin/refactor_dhd/tipo_via
     *
     * @return Response
     */
    public function RefactorDHDTipoVia()
    {
        $trabajos = DetalleHojaDiaria::all();

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