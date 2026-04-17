<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'titre',
        'message',
        'type',
        'id_facture',
        'id_reservation',
        'lu',
        'destinataire'
    ];

    protected $casts = [
        'lu' => 'boolean'
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_facture', 'id_facture');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation', 'id_reservation');
    }

    public static function notifierPaiement(Facture $facture): void
    {
        self::create([
            'titre'          => 'Nouveau paiement recu',
            'message'        => 'Le client ' . $facture->reservation->client->prenom . ' ' .
                                $facture->reservation->client->nom .
                                ' a paye la facture #' . $facture->id_facture .
                                ' d\'un montant de ' .
                                number_format($facture->montant_total, 0, ',', ' ') .
                                ' FCFA pour la chambre ' .
                                $facture->reservation->chambre->numero .
                                '. Veuillez valider sa reservation.',
            'type'           => 'paiement',
            'id_facture'     => $facture->id_facture,
            'id_reservation' => $facture->reservation->id_reservation,
            'lu'             => false,
            'destinataire'   => 'receptionniste',
        ]);
    }
}