<?php

/**
 *
 * @author earosb
 */
class Block extends \Eloquent {

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [
        'sector_id'  => 'required|exists:sector,id',
        'estacion'   => 'required',
        'nro_bien'   => 'required|max:10',
        'km_inicio'  => 'required|numeric|min:0',
        'km_termino' => 'required|numeric|min:0',
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'block';
    /**
     * Cosas que se pueden modificar
     * @var array
     */
    protected $fillable = array( 'sector_id', 'estacion', 'nro_bien', 'km_inicio', 'km_termino' );

    /**
     * Cosas que no se pueden modificar
     * @var array
     */
    protected $guarded = array( 'id' );

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector() {
        return $this->belongsTo('Sector');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desviadores() {
        return $this->hasMany('Desviador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desvios() {
        return $this->hasMany('Desvio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleHojaDiaria() {
        return $this->hasMany('DetalleHojaDiaria');
    }

}