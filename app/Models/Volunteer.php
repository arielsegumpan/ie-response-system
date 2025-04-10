<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'availability_status',
        'certification_info',
        'verification_status',
        'notes',
    ];

    protected $casts = [
        'certification_info' => 'array',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function volunteerSkills() : HasMany
    {
        return $this->hasMany(VolunteerSkill::class);
                    // ->withPivot(['proficiency_level', 'certification_date', 'expiration_date'])
                    // ->withTimestamps();
    }
}
