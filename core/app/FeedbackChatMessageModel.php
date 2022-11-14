<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackChatMessageModel extends Model
{
    protected $table = 'feedback_chat_messages';

    public function principal()
    {
        return $this->belongsTo(Users::class, 'principal_code', 'user_code');
    }

}
