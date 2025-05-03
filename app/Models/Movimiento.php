<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'precio_unitario',
        'documento',
        'ingreso_id',
        'egreso_id',
        'observacion'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function ingreso()
    {
        return $this->belongsTo(Ingreso::class);
    }

    public function egreso()
    {
        return $this->belongsTo(Egreso::class);
    }
}

