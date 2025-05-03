<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
            $table->enum('tipo', ['ingreso', 'egreso', 'ajuste']);
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->string('documento')->nullable();
            $table->foreignId('ingreso_id')->nullable()->constrained('ingresos');
            $table->foreignId('egreso_id')->nullable()->constrained('egresos');
            $table->text('observacion')->nullable();
            $table->timestamps();
            
            $table->index('producto_id');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
};
