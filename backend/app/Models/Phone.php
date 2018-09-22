<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'sku_id', 'nume_produs', 'name', 'producator', 'caracteristici_principale', 'diagonala_ecran', 'camera', 'memorie_interna',
        'shop_id'
    ];

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }
}
