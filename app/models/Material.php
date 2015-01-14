<?php

/**
 *
 * @author earosb
 */

class Material extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'material';
	
	/**
	 * Add your validation rules here
	 * @var [type]
	 */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
	 * Don't forget to fill this array
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [hojasDiarias description]
	 * @return [type] [description]
	 */
	public function hojasDiarias()
    {
        return $this->belongsToMany('HojaDiaria', 'hoja_diaria_material', 'material_id', 'hoja_diaria_id');
    }

    /**
     * [tipoMaterial description]
     * @return [type] [description]
     */
    public function tipoMaterial()
    {
        return $this->belongsTo('Tipomaterial');
    }

}