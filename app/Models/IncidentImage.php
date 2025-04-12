<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'image_path',
    ];

    protected $casts = [
        'image_path' => 'array'
    ];

    public function incident() : BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }
}
