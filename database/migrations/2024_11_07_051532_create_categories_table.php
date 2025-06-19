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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table ->string('name');            
            $table->unsignedBigInteger('panel_id');
            $table->timestamps();
            //$table->foreign('panel_id')->references('id')->on('panels');
        });
           // Añadimos la columna category_id en la tabla tasks
           /*Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Relación con categorías
        });*/
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
