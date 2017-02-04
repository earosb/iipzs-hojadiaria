<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 * @author earosb
 */
class Deposito extends \Eloquent
{

    use SoftDeletingTrait;

    /**
     * Add your validation rules here
     */
    public static $rules = [
        'nombre' => 'required'
    ];

    protected $dates = [ 'deleted_at' ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'deposito';

    /**
     * Don't forget to fill this array
     */
    protected $fillable = [ 'nombre' ];


    public function detalleMaterialesRetirados()
    {
        return $this->hasMany('DetalleMaterialRetirado');
    }


    public function detalleMaterialesColocados()
    {
        return $this->hasMany('DetalleMaterialColocado');
    }


    public function cargas()
    {
        return $this->hasMany('Carga');
    }
}