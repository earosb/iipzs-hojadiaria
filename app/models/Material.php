<?php

/**
 *
 * @author earosb
 */
class Material extends \Eloquent {

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [ 'nombre'    => 'required',
                             'valor'     => 'required|numeric',
                             'proveedor' => 'required',
                             'unidad'    => 'required', ];
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'material';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleMaterialColocado() {
        return $this->hasMany('DetalleMaterialColocado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoMaterial() {
        return $this->hasMany('TrabajoMaterial');
    }

}