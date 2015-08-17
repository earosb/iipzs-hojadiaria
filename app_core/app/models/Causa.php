<?php

class Causa extends \Eloquent
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'causa';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versiones()
    {
        return $this->hasMany('CausaVersion');
    }
}