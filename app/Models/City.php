<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{

    use HasFactory;

    protected $fillable = [
        'province_id',
        'city_name',
        'city_description'
    ];

    public function province() : BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function barangays() : HasMany
    {
        return $this->hasMany(Barangay::class)->chaperone();
    }
}
