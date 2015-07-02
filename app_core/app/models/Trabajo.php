<?php

/**
 *
 * @author earosb
 */
class Trabajo extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trabajo';

    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoMantenimiento()
    {
        return $this->belongsTo('TipoMantenimiento');
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
    public function alias()
    {
        return $this->belongsTo('Trabajo', 'padre_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nombreOficial()
    {
        return $this->hasMany('Trabajo', 'padre_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoMaterial()
    {
        return $this->hasMany('TrabajoMaterial');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TrabajoPrograma()
    {
        return $this->hasMany('Programa', 'trabajo_id');
    }
}