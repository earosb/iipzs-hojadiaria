<?php

class Carga extends \Eloquent
{

    public static $rules = [
        'alias'       => 'required', //'required|max:10',
        'fecha'       => 'required|date',
        'total'       => 'required|numeric',
        'deposito_id' => 'required|exists:deposito,id',
        'material_id' => 'required|exists:material,id'
    ];

    protected $fillable = [ 'alias', 'fecha', 'total', 'restante', 'deposito_id' ];

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