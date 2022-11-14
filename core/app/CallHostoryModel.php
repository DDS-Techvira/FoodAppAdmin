<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallHostoryModel extends Model
{
    //
    protected $table = 'call_history';
    
    public function user()
    {
        return $this->belongsTo('App\ScheduledAppointments', 'appointments_code', 'appointment_id');
    }
}
