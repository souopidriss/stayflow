<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('message');
            $table->enum('type', ['paiement', 'reservation', 'info'])->default('info');
            $table->unsignedBigInteger('id_facture')->nullable();
            $table->unsignedBigInteger('id_reservation')->nullable();
            $table->boolean('lu')->default(false);
            $table->enum('destinataire', ['receptionniste', 'admin', 'tous'])->default('tous');
            $table->timestamps();

            $table->foreign('id_facture')
                  ->references('id_facture')
                  ->on('factures')
                  ->onDelete('cascade');

            $table->foreign('id_reservation')
                  ->references('id_reservation')
                  ->on('reservations')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};