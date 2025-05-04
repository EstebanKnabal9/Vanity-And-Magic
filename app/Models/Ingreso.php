<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'costo_unitario',
        'costo_total',
        'tipo_ingreso',
        'documento',
        'proveedor_id',
        'observacion',
        'fecha_ingreso'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    // Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
