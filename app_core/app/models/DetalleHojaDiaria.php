<?php

/**
 *
 * @author earosb
 */

class DetalleHojaDiaria extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'detalle_hoja_diaria';

	/**
	 * Add your validation rules here
	 */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
	 * Don't forget to fill this array
	 */
	protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function hojaDiaria()
    {
        return $this->belongsTo('HojaDiaria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trabajo()
    {
        return $this->belongsTo('Trabajo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo('Block');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function desviador()
    {
        return $this->belongsTo('Desviador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function desvio()
    {
        return $this->belongsTo('Desvio');
    }
}