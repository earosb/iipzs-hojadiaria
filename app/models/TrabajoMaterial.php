<?php

/**
 *
 * @author earosb
 */
class TrabajoMaterial extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trabajo_material';

    /**
     * Don't forget to fill this array
     */
    protected $fillable = ['trabajo_id', 'material_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material()
    {
        return $this->belongsTo('Material');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trabajo()
    {
        return $this->belongsTo('Trabajo');
    }

}