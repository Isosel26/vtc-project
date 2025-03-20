<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChauffeursTable extends Migration
{
    public function up()
    {
        Schema::create('chauffeurs', function (Blueprint $table) {
            $table->id(); // clé primaire
            $table->string('name'); // nom du chauffeur
            $table->string('email')->unique(); // email unique
            $table->string('password'); // mot de passe haché
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chauffeurs');
    }
}
