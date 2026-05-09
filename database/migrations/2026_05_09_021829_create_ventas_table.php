<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('id_venta')->nullable();
            $table->date('fecha')->nullable();
            $table->string('producto')->nullable();
            $table->string('categoria')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('region')->nullable();
            $table->string('estado_limpieza')->default('Sin revisar');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};