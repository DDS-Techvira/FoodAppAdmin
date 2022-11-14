<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebinarModel extends Model
{
    protected $table = 'webinar';

    public function coach()
    {
        return $this->belongsTo(Users::class, 'coach_code', 'user_code');
    }

    public function users()
    {
        return $this->belongsToMany(Users::class, WebinarUsersModel::class, 'webinar_code', 'prinicpal_code');
    }
}
