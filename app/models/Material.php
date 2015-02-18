<?php

/**
 *
 * @author earosb
 */
class Material extends \Eloquent
{

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'material';

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [
        'nombre'    => 'required',
        'valor'     => 'required|numeric',
        'proveedor' => 'required',
        'unidad'    => 'required',
    ];

    /**
     * Don't forget to fill this array
     * @var [type]
     */
    protected $fillable = [];

    /**
     * @return mixed
     */
    public function detalleMaterialColocado()
    {
        return $this->hasMany('DetalleMaterialColocado');
    }

}