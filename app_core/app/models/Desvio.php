<?php

/**
 *
 * @author earosb
 */
class Desvio extends \Eloquent
{
    /**
     * @var array con reglas de validación
     */
    public static $rules = array(
        'nombre' => 'required',
        'selectsectorDesvio' => 'required|numeric|exists:sector,id',
        'selectblockDesvio' => 'required|numeric|exists:block,id',
        'selectdesviador_norte' => 'numeric|exists:desviador,id',
        'selectdesviador_sur' => 'numeric|exists:desviador,id',
    );
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'desvio';
    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function desviadorNorte()
    {
        return $this->hasOne('Desviador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function desviadorSur()
    {
        return $this->hasOne('Desviador');
    }
}