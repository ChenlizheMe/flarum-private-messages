<?php

namespace ChenlizheMe\FlarumPrivateMessages;

use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Flarum\User\User;
use ChenlizheMe\FlarumPrivateMessages\Conversation;

class Message extends AbstractModel
{
    protected $table = 'messages';

    public $timestamps = true;

    protected $dates = ['created_at'];

    public $fillable = [
        'message',
        'is_seen',
        'is_hidden',
        'user_id',
        'conversation_id',
    ];

    public static function newMessage($messageContent, $senderId, $conversationId)
    {
        $message = new static;

        $message->message = $messageContent;
        $message->user_id = $senderId;
        $message->created_at = Carbon::now();
        $message->conversation_id = $conversationId;

        return $message;
    }

    public static function findOrFail($id)
    {
        $query = static::where('id', $id);

        return $query->firstOrFail();
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
