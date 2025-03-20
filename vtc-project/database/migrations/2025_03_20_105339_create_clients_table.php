<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // clé primaire auto-incrémentée
            $table->string('name'); // nom du client
            $table->string('email')->unique(); // email unique
            $table->string('password'); // mot de passe (haché)
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
