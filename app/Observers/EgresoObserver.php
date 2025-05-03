<?php

namespace App\Observers;

use App\Models\Egreso;
use App\Models\Producto;

class EgresoObserver
{
    public function created(Egreso $egreso)
    {
        $producto = Producto::find($egreso->producto_id);
        if ($producto) {
            $producto->decrement('stock', $egreso->cantidad);
        }
    }
}
