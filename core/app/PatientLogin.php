<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientLogin extends Model
{
    protected $guarded = ['id'];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
