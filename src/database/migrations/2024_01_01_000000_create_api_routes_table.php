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
            $table->string('type');
            $table->string('route');
            $table->string('controller')->nullable();
            $table->string('class')->nullable();
            $table->string('function')->nullable();
            $table->string('name')->nullable();
            $table->string('middleware')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_routes');
    }
}
