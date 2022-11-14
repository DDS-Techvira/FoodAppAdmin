<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachAvailableDetail extends Model
{
    protected $table = 'coach_availability_detail';
    protected $guarded = ['id'];
    protected $casts = [
        'time_slots_15' => 'object',
        'time_slots_30' => 'object',
        'time_slots_60' => 'object',
    ];
}
