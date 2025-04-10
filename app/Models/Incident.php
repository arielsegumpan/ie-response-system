<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'incident_type_id',
        'verified_by',
        'title',
        'slug',
        'description',
        'status',
        'verification_date',
        'priority',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'verification_date' => 'datetime',
    ];

    public function type() : BelongsTo
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }

    public function reporter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function verifier() : BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function images() : HasMany
    {
        return $this->hasMany(IncidentImage::class);
    }

    public function locations() : HasMany
    {
        return $this->hasMany(IncidentLocation::class);
    }

    public function responses() : HasMany
    {
        return $this->hasMany(Response::class);
    }
}
