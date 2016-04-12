<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 * @author earosb
 */
class Material extends \Eloquent
{

    use SoftDeletingTrait;

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [
        'nombre'    => 'required',
        'valor'     => 'required|numeric|min:0',
        'proveedor' => 'required',
        'unidad'    => 'required',
    ];

    protected $dates = [ 'deleted_at' ];

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'material';

    /**
     * @var array
     */
    protected $fillable = [ ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleMaterialColocado()
    {
        return $this->hasMany('DetalleMaterialColocado');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoMaterial()
    {
        return $this->hasMany('TrabajoMaterial');
    }


    public function cargas()
    {
        return $this->hasMany('Carga');
    }

}