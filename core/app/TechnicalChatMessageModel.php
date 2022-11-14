<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicalChatMessageModel extends Model
{
    protected $table = 'technical_chat_messages';

    public function principal()
    {
        return $this->belongsTo(Users::class, 'principal_code', 'user_code');
    }

    public function technicalUser()
    {
        return $this->belongsTo(Admin::class, 'technical_user_code', 'id');
    }
}
