<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 * @author earosb
 */
class GrupoTrabajo extends \Eloquent
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function GrupoPrograma()
    {
        return $this->hasMany('Programa', 'grupo_trabajo_id');
    }

}