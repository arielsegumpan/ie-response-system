<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'barangay_name',
        'barangay_description'
    ];

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
