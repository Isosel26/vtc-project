<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chauffeurs', function (Blueprint $table) {
            // Ajoute la colonne statut avec 3 valeurs possibles, pending par défaut
            $table->enum('statut', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('chauffeurs', function (Blueprint $table) {
            // Supprime la colonne si on annule la migration
            $table->dropColumn('statut');
        });
    }
};
