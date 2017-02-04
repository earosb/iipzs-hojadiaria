<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 * @author earosb
 */
class MaterialRetirado extends \Eloquent
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Reglas de validación
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'material_retirado';
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