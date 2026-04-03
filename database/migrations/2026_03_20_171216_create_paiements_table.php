<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_facture')->constrained('factures', 'id_facture')->onDelete('cascade');
            $table->string('telephone');
            $table->string('code_otp', 6);
            $table->enum('operateur', ['mtn', 'orange']);
            $table->boolean('utilise')->default(false);
            $table->timestamp('expire_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_paiements');
    }
};