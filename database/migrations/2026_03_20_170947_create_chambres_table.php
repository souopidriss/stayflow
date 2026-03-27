<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chambres', function (Blueprint $table) {
            $table->id('id_chambre');
            $table->foreignId('id_type')->constrained('type_chambres', 'id_type')->onDelete('restrict');
            $table->string('numero')->unique();
            $table->decimal('prix_nuit', 10, 2);
            $table->enum('statut', ['Libre', 'Occupé', 'Maintenance'])->default('Libre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};