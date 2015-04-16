<?php

/**
 *
 * @author earosb
 */
class TipoMantenimiento extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_mantenimiento';

    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajos()
    {
        return $this->hasMany('Trabajo')->orderBy('nombre', 'asc');
    }
}