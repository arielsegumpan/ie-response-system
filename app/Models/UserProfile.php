<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'first_name',
        'last_name',
        'phone',
        'gender',
        'dob',
        'pob',
        'emergency_contact',
        'emergency_phone',
        'emergency_email',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address() : BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

}
