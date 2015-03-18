<?php

/**
 *
 * @author earosb
 */
class HojaDiaria extends \Eloquent
{

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'hoja_diaria';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleMaterialRetirado()
    {
        return $this->hasMany('DetalleMaterialRetirado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleHojaDiaria()
    {
        return $this->hasMany('DetalleHojaDiaria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupoTrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleMaterialColocado()
    {
        return $this->hasMany('DetalleMaterialColocado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}