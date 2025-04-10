<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'latitude',
        'longitude',
        'location_description',
        'landmark',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function incident() : BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }
}
