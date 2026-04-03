<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpPaiement extends Model
{
    protected $table = 'otp_paiements';

    protected $fillable = [
        'id_facture',
        'telephone',
        'code_otp',
        'operateur',
        'utilise',
        'expire_at'
    ];

    protected $casts = [
        'expire_at' => 'datetime',
        'utilise'   => 'boolean'
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_facture', 'id_facture');
    }

    public function isExpire(): bool
    {
        return $this->expire_at->isPast();
    }

    public static function genererCode(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}