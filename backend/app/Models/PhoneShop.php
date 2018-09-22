<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneShop extends Model
{
    protected $table = 'phone_shop';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id', 'phone_id'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
