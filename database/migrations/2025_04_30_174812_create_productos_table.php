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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('codigo', 100)->nullable()->unique();
            $table->boolean('estado')->default(true);

            // Relaciones
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('subcategoria_id')->nullable();

            // Claves foráneas
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('set null');

            // Timestamps de Laravel (created_at y updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
