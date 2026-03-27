<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';
    protected $primaryKey = 'id_paiement';

    protected $fillable = [
        'id_facture',
        'date_paiement',
        'montant',
        'mode_paiement',
        'statut'
    ];

    protected $casts = [
        'date_paiement' => 'date'
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_facture', 'id_facture');
    }
}