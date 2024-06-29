<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('api_routes', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Tipo de ruta (GET, POST, etc.)
            $table->string('route'); // Ruta
            $table->string('controller')->nullable(); // Controlador
            $table->string('class')->nullable(); // Clase del controlador
            $table->string('name')->nullable(); // Nombre de la ruta
            $table->string('functions')->nullable();
            $table->string('middleware')->nullable(); // Middleware
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_routes');
    }
}
