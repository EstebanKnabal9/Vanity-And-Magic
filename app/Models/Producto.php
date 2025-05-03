<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Movimiento;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',         // Precio actual de venta
        'stock_minimo',   // Nuevo: para alertas
        'codigo',
        'estado',
        'categoria_id',
        'subcategoria_id',
        'proveedor_id'    // Asegúrate de tener este campo si lo necesitas
    ];

    protected $appends = ['stock_actual']; // Accesor disponible en JSON

    // 1. RELACIONES EXISTENTES
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class);
    }

    // 2. NUEVAS RELACIONES CON MOVIMIENTOS
    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function ingresos(): HasMany
    {
        return $this->hasMany(Ingreso::class);
    }

    public function egresos(): HasMany
    {
        return $this->hasMany(Egreso::class);
    }

    // 3. ACCESORES (CÁLCULO DINÁMICO)
    public function getStockActualAttribute(): float
    {
        return $this->movimientos()
            ->selectRaw('SUM(CASE WHEN tipo = "ingreso" THEN cantidad ELSE -cantidad END) as total')
            ->value('total') ?? 0;
    }

    public function getDisponibleAttribute(): bool
    {
        return $this->stock_actual > 0;
    }

    // 4. SCOPES ÚTILES
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeConStockBajo($query)
    {
        return $query->whereRaw('(
            SELECT SUM(CASE WHEN tipo = "ingreso" THEN cantidad ELSE -cantidad END) 
            FROM movimientos 
            WHERE producto_id = productos.id
        ) < productos.stock_minimo');
    }

    // 5. MÉTODOS PARA ACTUALIZAR STOCK
    public function actualizarStock(float $cantidad, string $tipo): void
    {
        if (!in_array($tipo, ['ingreso', 'egreso'])) {
            throw new \InvalidArgumentException("Tipo de movimiento inválido");
        }

        $this->movimientos()->create([
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'user_id' => auth()->id(),
            'precio_unitario' => $this->precio
        ]);
    }
}