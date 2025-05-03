<?php

namespace App\Observers;

use App\Models\Ingreso;
use App\Models\Producto;

class IngresoObserver
{
    public function created(Ingreso $ingreso)
    {
        $producto = Producto::find($ingreso->producto_id);
        if ($producto) {
            $producto->increment('stock', $ingreso->cantidad);
        }
    }
}
