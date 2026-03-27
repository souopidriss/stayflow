<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    protected $table = 'receptions';
    protected $primaryKey = 'id_reception';

    protected $fillable = [
        'id_reservation',
        'date_arrivee',
        'date_depart',
        'montant_paye'
    ];

    protected $casts = [
        'date_arrivee' => 'date',
        'date_depart'  => 'date'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation', 'id_reservation');
    }
}