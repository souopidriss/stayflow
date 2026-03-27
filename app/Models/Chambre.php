<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $table = 'chambres';
    protected $primaryKey = 'id_chambre';

    protected $fillable = [
        'id_type',
        'numero',
        'prix_nuit',
        'statut'
    ];

    public function typeChambre()
    {
        return $this->belongsTo(TypeChambre::class, 'id_type', 'id_type');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_chambre', 'id_chambre');
    }

    public function isLibre(): bool
    {
        return $this->statut === 'Libre';
    }
}