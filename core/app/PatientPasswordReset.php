<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffPasswordReset extends Model
{
    protected $table = "patient_password_resets";
    protected $guarded = ['id'];
    public $timestamps = false;
}
