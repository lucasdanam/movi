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
        Schema::create('dador_transportistas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dador_id')->unsigned();
            $table->bigInteger('transportista_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dador_transportistas');
    }
};
