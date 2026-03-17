<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('intento_logins', function (Blueprint $table) {
            $table->id(); // ID del intento
            $table->string('correo'); // Correo del usuario
            $table->integer('intentos')->default(0); // Número de intentos fallidos
            $table->timestamp('ultimo_intento')->nullable(); // Fecha y hora del último intento
            $table->timestamp('bloqueado_hasta')->nullable(); // Fecha y hora hasta que está bloqueado
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('intento_logins');
    }
}
