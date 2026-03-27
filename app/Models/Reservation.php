<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'id_reservation';

    protected $fillable = [
        'id_client',
        'id_chambre',
        'date_reservation',
        'date_arrivee',
        'date_depart',
        'statut'
    ];

    protected $casts = [
        'date_reservation' => 'date',
        'date_arrivee'     => 'date',
        'date_depart'      => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }

    public function chambre()
    {
        return $this->belongsTo(Chambre::class, 'id_chambre', 'id_chambre');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'reservation_service', 'id_reservation', 'id_service')
                    ->withPivot('quantite', 'montant')
                    ->withTimestamps();
    }

    public function facture()
    {
        return $this->hasOne(Facture::class, 'id_reservation', 'id_reservation');
    }

    public function reception()
    {
        return $this->hasOne(Reception::class, 'id_reservation', 'id_reservation');
    }

    public function getNombreNuitsAttribute(): int
    {
        return $this->date_arrivee->diffInDays($this->date_depart);
    }
}