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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('proveedor_id')->nullable(); // Puede no tener proveedor
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');

            // Campos de datos
            $table->integer('cantidad');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('costo_total', 12, 2);
            $table->string('tipo_ingreso'); // ejemplo: 'compra', 'ajuste', etc.
            $table->string('documento')->nullable();
            $table->text('observacion')->nullable();
            $table->date('fecha_ingreso');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};
