<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trufi extends Model
{
    protected $table = 'trufis';

    protected $primaryKey = 'idtrufi';

    // Si Tu PK No Se Llama "id", Esto Ayuda A Eloquent
    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nom_linea',
        'costo',
        'frecuencia',
        'tipo',
        'descripcion',
        'estado',
        'sindicato_id',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'costo' => 'decimal:2',
    ];

    // Relaciones
    public function rutas()
    {
        return $this->hasMany(TrufiRuta::class, 'idtrufi', 'idtrufi');
    }

    public function sindicato()
    {
        return $this->belongsTo(Sindicato::class, 'sindicato_id', 'id');
    }

    // Opcional: Compatibilidad Si En Algún Lado Aún Usas "nombre"
    public function getNombreAttribute()
    {
        return $this->nom_linea;
    }

    // Opcional: Compatibilidad Si En Algún Lado Aún Usas "nombre_sindicato"
    public function getNombreSindicatoAttribute()
    {
        return $this->sindicato?->nombre;
    }

    public function detalle()
    {
        return $this->hasOne(TrufiDetalle::class, 'trufi_id', 'idtrufi');
    }

    public function rutaUbicaciones()
    {
        return $this->hasMany(TrufiRutaUbicacion::class, 'idtrufi', 'idtrufi')
            ->orderBy('orden');
    }
}
