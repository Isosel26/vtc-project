<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // référence au client qui demande la course
            $table->unsignedBigInteger('chauffeur_id')->nullable(); // référence au chauffeur qui accepte la course (nullable tant que non acceptée)
            $table->string('departure'); // lieu de départ
            $table->string('destination'); // destination
            $table->dateTime('scheduled_at'); // date et heure programmées
            $table->enum('status', ['pending', 'accepted', 'finished'])->default('pending'); // statut de la course
            $table->timestamps();

            // Définition des clés étrangères
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('chauffeur_id')->references('id')->on('chauffeurs')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
