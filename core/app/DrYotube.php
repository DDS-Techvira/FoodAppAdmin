<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrYotube extends Model
{
    protected $table = 'doctor_videos';

    public function sector(){

        return $this->belongsTo(Sector::class);
    }
}
