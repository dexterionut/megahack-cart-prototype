<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $withCount = ['phones'];
    protected $fillable = [
        'dealer_name', 'city', 'county', 'address', 'telefon', 'email', 'luni', 'marti', 'miercuri', 'joi', 'vineri', 'sambata',
        'duminica', 'latitude', 'longitude', 'profil_magazin', 'cod_postal'
    ];

    public function phones()
    {
        return $this->belongsToMany(Phone::class);
    }
}
