<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $table = 'factures';
    protected $primaryKey = 'id_facture';

    protected $fillable = [
        'id_reservation',
        'date_facture',
        'montant_total',
        'statut'
    ];

    protected $casts = [
        'date_facture' => 'date'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation', 'id_reservation');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_facture', 'id_facture');
    }

    public static function genererNumero(): string
    {
        return 'FAC-' . date('Y') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
    }
}