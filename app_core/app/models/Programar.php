<?php

class Programar extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'programar';

    /**
     * @var array
     */
    protected $fillable = ['causa', 'cantidad', 'trabajo_id', 'km_inicio', 'km_termino'];

    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [
        'causa' => 'required',
        'trabajo_id' => 'required|exists:trabajo,id',
        'km_inicio' => 'required|numeric|min:0',
        'km_termino' => 'required|numeric|min:0',
        'cantidad' => 'required|numeric|min:0',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Trabajo()
    {
        return $this->belongsTo('Trabajo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function GrupoTrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }
}