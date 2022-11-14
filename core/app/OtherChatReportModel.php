<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherChatReportModel extends Model
{
    protected $table = 'other_chat_messages_report';

    public function principal()
    {
        return $this->belongsTo(Users::class, 'principal_code', 'user_code');
    }

    public function technicalUser()
    {
        return $this->belongsTo(Admin::class, 'admin_user_code', 'id');
    }
}
