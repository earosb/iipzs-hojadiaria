<?php

class Carga extends \Eloquent
{

    public static $rules = [
        'tipo'        => 'required',
        'fecha'       => 'required|date',
        'cantidad'    => 'required|numeric',
        'deposito'    => 'required|exists:deposito,id',
        'material'    => 'required|exists:material,id'
    ];

    protected $fillable = [ 'tipo', 'fecha', 'cantidad', 'obs', 'deposito_id', 'material_id' ];

    protected $table = 'carga';


    public function deposito()
    {
        return $this->belongsTo('Deposito', 'deposito_id');
    }


    public function material()
    {
        return $this->belongsTo('Material', 'material_id');
    }

}