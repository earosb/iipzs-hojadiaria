<?php

class Sector extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sector';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function blocks()
    {
        return $this->hasMany('Block');
    }


}