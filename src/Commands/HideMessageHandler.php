<?php

namespace ChenlizheMe\FlarumPrivateMessages\Commands;

use Flarum\User\Exception\PermissionDeniedException;
use ChenlizheMe\FlarumPrivateMessages\Message;

class HideMessageHandler
{
    public function handle(HideMessage $command)
    {
        $actor = $command->actor;
        $messageId = $command->messageId;

        $actor->assertCan('deleteMessage');

        $message = Message::find($messageId);

        if ($actor->id != $message->user_id) {
            throw new PermissionDeniedException;
        }

        $message->is_hidden = true;

        $message->save();
    }
}
