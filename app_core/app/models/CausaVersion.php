<?php

class CausaVersion extends \Eloquent {

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'causa_version';

    /**
     * @var array
     */
	protected $fillable = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function causa()
	{
		return $this->belongsTo('Causa');
	}
}