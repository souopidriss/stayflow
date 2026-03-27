<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('restrict');
            $table->foreignId('id_chambre')->constrained('chambres', 'id_chambre')->onDelete('restrict');
            $table->date('date_reservation');
            $table->date('date_arrivee');
            $table->date('date_depart');
            $table->enum('statut', ['en_attente', 'confirmee', 'checkin', 'checkout', 'annulee'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};