<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessagesModel extends Model
{
    protected $table = 'chat_messages';

    public function principal()
    {
        return $this->belongsTo(Users::class, 'principal_code', 'user_code');
    }

    public function coach()
    {
        return $this->belongsTo(Users::class, 'coach_code', 'user_code');
    }
}
