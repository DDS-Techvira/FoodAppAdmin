<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatsReportModel extends Model
{
    protected $table = 'chat_messages_report';

    public function principal()
    {
        return $this->belongsTo(Users::class, 'principal_code', 'user_code');
    }

    public function coach()
    {
        return $this->belongsTo(Users::class, 'coach_code', 'user_code');
    }
}
