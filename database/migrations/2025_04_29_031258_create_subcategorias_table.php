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
    Schema::create('subcategorias', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255)->unique();
        $table->text('descripcion')->nullable();
        $table->boolean('estado')->default(true);
        $table->unsignedBigInteger('id_categoria');
        $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategorias');
    }
};
