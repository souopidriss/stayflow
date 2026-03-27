<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->id('id_reception');
            $table->foreignId('id_reservation')->constrained('reservations', 'id_reservation')->onDelete('restrict');
            $table->date('date_arrivee');
            $table->date('date_depart');
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};