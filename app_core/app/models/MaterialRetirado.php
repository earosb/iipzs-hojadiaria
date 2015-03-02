<?php

/**
 *
 * @author earosb
 */

class MaterialRetirado extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'material_retirado';

    /**
     * Reglas de validación
     * @var array
     */
    public static $rules = [
        'nombre'    => 'required',
    ];

	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function detalleMaterialRetirado()
    {
        return $this->hasMany('DetalleMaterialRetirado');
    }
}