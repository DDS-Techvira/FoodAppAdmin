<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachAvailabilityModel extends Model
{
    protected $table = 'coach_availability';
    protected $guarded = ['id'];
    protected $casts = [
        'slots' => 'object',
    ];
}
