<?php

/**
 *
 * @author earosb
 */

class TipoMaterial extends \Eloquent {

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'tipo_material';
	
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
	 * [materiales description]
	 * @return [type] [description]
	 */
	public function materiales()
    {
        return $this->hasMany('Material');
    }

}