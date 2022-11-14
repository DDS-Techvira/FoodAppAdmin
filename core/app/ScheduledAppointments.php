<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledAppointments extends Model
{
    protected $table = 'scheduled_appointments';

    public function callHistory()
    {
        return $this->hasOne('App\CallHostoryModel', 'appointment_id', 'appointments_code');
    }
}
