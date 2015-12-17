<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 *
 * @author earosb
 */
class Desviador extends \Eloquent
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [

    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desviador';
    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = ['nombre', 'km_inicio', 'block_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo('Block');
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
    public function desvioNorte()
    {
        return $this->belongsTo('Block');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function desvioSur()
    {
        return $this->belongsTo('Block');
    }

}