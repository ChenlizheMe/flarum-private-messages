<?php

namespace ChenlizheMe\FlarumPrivateMessages\Notifications;

use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use ChenlizheMe\FlarumPrivateMessages\Message;

class NewPrivateMessageBlueprint implements BlueprintInterface, MailableInterface
{
    public $message;
    public $conversation;
    public $user;
    public $primaryColor;
    public $secondaryColor;

    public function __construct(Message $message, $conversation, $user, SettingsRepositoryInterface $settings)
    {
        $this->message = $message;
        $this->conversation = $conversation;
        $this->user = $user;
        $this->primaryColor = $settings->get('theme_primary_color');
        $this->secondaryColor = $settings->get('theme_secondary_color');
    }

    public function getSubject()
    {
        return $this->message;
    }

    public function getFromUser()
    {
        return $this->user;
    }

    public function getData()
    {
        return [
            'message' => $this->message,
            'conversation' => $this->conversation,
            'fromUser' => $this->user
        ];
    }

    public static function getType()
    {
        return 'newPrivateMessage';
    }

    public static function getSubjectModel()
    {
        return Message::class;
    }

    public function getEmailView()
    {
        return [
            'text' => 'flarum-private-messages::emails.newPrivateMessageText',
            'html' => 'flarum-private-messages::emails.newPrivateMessageHtml'
        ];
    }

    public function getEmailSubject(TranslatorInterface $translator)
    {
        return $translator->trans('chenlizheme-private-messages.forum.notifications.email.new_private_message.subject', [
             '{user}' => $this->user->display_name
        ]);
    }
}
