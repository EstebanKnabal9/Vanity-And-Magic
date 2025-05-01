<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('producto_id'); // Producto relacionado
            $table->unsignedBigInteger('proveedor_id')->nullable(); // Proveedor, en caso de devolución
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');

            // Datos del egreso
            $table->integer('cantidad'); // Unidades egresadas
            $table->decimal('costo_unitario', 10, 2); // Precio unitario al momento del egreso
            $table->decimal('costo_total', 12, 2); // Total = cantidad * costo_unitario

            // Tipo de egreso
            $table->enum('tipo_egreso', [
                'venta',                // Por ventas
                'devolucion_proveedor',// Devolución al proveedor
                'ajuste_negativo',     // Ajustes negativos
                'consumo_interno'      // Consumo dentro de la empresa
            ]);

            // Documento de referencia generado automáticamente
            $table->string('documento')->nullable();

            // Comentarios u observaciones
            $table->text('observacion')->nullable();

            // Fecha del movimiento
            $table->date('fecha_egreso');

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
