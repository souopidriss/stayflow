<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_reservation')->constrained('reservations', 'id_reservation')->onDelete('cascade');
            $table->foreignId('id_service')->constrained('services', 'id_service')->onDelete('restrict');
            $table->integer('quantite')->default(1);
            $table->decimal('montant', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_service');
    }
};