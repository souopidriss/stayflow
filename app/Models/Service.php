<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'id_employe',
        'nom',
        'prix',
        'description'
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_service', 'id_service', 'id_reservation')
                    ->withPivot('quantite', 'montant')
                    ->withTimestamps();
    }
}