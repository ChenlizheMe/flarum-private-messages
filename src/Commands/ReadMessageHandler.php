<?php

namespace ChenlizheMe\FlarumPrivateMessages\Commands;

use Carbon\Carbon;
use Flarum\User\Exception\PermissionDeniedException;
use ChenlizheMe\FlarumPrivateMessages\Conversation;
use ChenlizheMe\FlarumPrivateMessages\ConversationUser;
use ChenlizheMe\FlarumPrivateMessages\Message;
use Pusher\Pusher;

class ReadMessageHandler
{
    public function handle(ReadMessage $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $conversation = Conversation::find($data['conversationId']);

        $convUser = $conversation->recipients()->where('user_id', $actor->id)->first();

        if (!$convUser) {
            throw new PermissionDeniedException;
        }

        $oldRead = $convUser->last_read_message_number;

        $message = Message::find($data['messageId']);
        
        if ($message->conversation_id != $conversation->id) {
            throw new PermissionDeniedException;
        }

        $number = $message->number;

        if ($number > $convUser->last_read_message_number) {
            $convUser->last_read_message_number = $number;
            $convUser->last_read_at = Carbon::now();
        }

        $convUser->save();

        $actor->decrement('unread_messages', $number - $oldRead);

        if ($actor->unread_messages < 0) {
            $actor->unread_messages = 0;
            $actor->save();
        }

        foreach (ConversationUser::where('conversation_id', $conversation->id)->pluck('user_id')->all() as $userId) {
            if (intval($userId) !== intval($actor->id)) {
                $this->pushNewRead($userId, $number, $conversation->id, $actor->id);
            }
        }

        return $convUser;
    }

    public function pushNewRead($userId, $messageNumber, $conversationId, $actorId)
    {
        if (app()->bound(Pusher::class)) {
            app(Pusher::class)->trigger('private-user' . $userId, 'readMessage', [
                'number' => $messageNumber,
                'readBy' => $actorId,
                'conversationId' => $conversationId
            ]);
        }
    }
}
