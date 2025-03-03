<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'province_id',
        'city_id',
        'barangay_id',
        'street',
        'postal_code',
        'latitude',
        'longitude',
    ];


    public function province() : BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function barangay() : BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

}
