<?php

/**
 *
 * @author earosb
 */
class GrupoTrabajo extends \Eloquent
{
    /**
     * Add your validation rules here
     */
    public static $rules = [
        'base' => 'required'
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grupo_trabajo';
    /**
     * Don't forget to fill this array
     */
    protected $fillable = ['base'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hojasDiarias()
    {
        return $this->hasMany('HojaDiaria');
    }

}