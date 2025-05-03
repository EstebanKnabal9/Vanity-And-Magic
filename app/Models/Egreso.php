<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Egreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'cantidad',
        'costo_unitario',
        'costo_total',
        'tipo_egreso',
        'documento',
        'observacion',
        'fecha_egreso'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function movimiento()
    {
        return $this->hasOne(Movimiento::class);
    }
}
