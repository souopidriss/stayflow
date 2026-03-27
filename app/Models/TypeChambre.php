<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeChambre extends Model
{
    protected $table = 'type_chambres';
    protected $primaryKey = 'id_type';

    protected $fillable = [
        'libelle_type',
        'capacite',
        'prix_nuit'
    ];

    public function chambres()
    {
        return $this->hasMany(Chambre::class, 'id_type', 'id_type');
    }
}