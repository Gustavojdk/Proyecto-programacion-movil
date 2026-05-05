<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrufiRuta extends Model
{
    protected $table = 'trufi_rutas';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'idtrufi',
        'sindicato_radiotaxi_id',
        'latitud',
        'longitud',
        'orden',
        'puntos',
        'es_parada',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'es_parada' => 'boolean',
        'puntos' => 'boolean',
    ];

    public function trufi()
    {
        return $this->belongsTo(Trufi::class, 'idtrufi', 'idtrufi');
    }

    public function sindicatoRadiotaxi()
    {
        return $this->belongsTo(SindicatoRadiotaxi::class, 'sindicato_radiotaxi_id');
    }
}
