<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebinarUsersModel extends Model
{
    protected $table = 'webinar_users';
    
    public function prinicpal()
    {
        return $this->belongsTo(Users::class, 'prinicpal_code', 'user_code');
    }
}
