<?php

class Sector extends \Eloquent
{
    /**
     * Add your validation rules here
     * @var [type]
     */
    public static $rules = [
        'nombre' => 'required',
        'estacion_inicio' => 'required',
        'estacion_termino' => 'required',
        'km_inicio' => 'required|numeric|min:0',
        'km_termino' => 'required|numeric|min:0',
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sector';

    /**
     * Don't forget to fill this array
     * @var [type]
     */
    protected $fillable = ['nombre', 'estacion_inicio', 'estacion_termino', 'km_inicio', 'km_termino'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany('Block');
    }
}