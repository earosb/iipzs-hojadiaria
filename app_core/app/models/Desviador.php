<?php

/**
 *
 * @author earosb
 */
class Desviador extends \Eloquent {

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
     * Add your validation rules here
     * @var [type]
     */
	public static $rules = [

	];

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