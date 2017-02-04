<?php

/**
 *
 * @author earosb
 */
class DetalleMaterialRetirado extends \Eloquent
{

    /**
     * Add your validation rules here
     */
    public static $rules = [
        // 'title' => 'required'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_material_retirado';

    /**
     * Don't forget to fill this array
     */
    protected $fillable = [ ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materialRetirado()
    {
        return $this->belongsTo('MaterialRetirado');
    }


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
    public function deposito()
    {
        return $this->belongsTo('Deposito');
    }
}