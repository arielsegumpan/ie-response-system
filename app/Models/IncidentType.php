<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'inc_name',
        'inc_slug',
        'inc_description'
    ];

    protected $casts = [
        'inc_required_resources' => 'array',
    ];

    public function incidents() : HasMany
    {
        return $this->hasMany(Incident::class, 'incident_type_id');
    }
}
