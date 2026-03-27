<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employes';
    protected $primaryKey = 'id_employe';

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'poste',
        'telephone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'id_employe', 'id_employe');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_employe', 'id_employe');
    }
}