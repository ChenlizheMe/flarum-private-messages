<?php

namespace ChenlizheMe\FlarumPrivateMessages;

use Flarum\Api\Controller;
use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\User\User;
use ChenlizheMe\FlarumPrivateMessages\Api\Controllers;
use ChenlizheMe\FlarumPrivateMessages\Api\Serializers\ConversationRecipientSerializer;
use ChenlizheMe\FlarumPrivateMessages\Api\Serializers\MessageSerializer;
use ChenlizheMe\FlarumPrivateMessages\Notifications\NewPrivateMessageBlueprint;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/extension.less')
        ->route('/conversations/{id}', 'chenlizheme-private-messages.messages')
        ->route('/conversations', 'chenlizheme-private-messages.conversations'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    // (new Extend\Model(User::class))
    //     ->hasMany('conversations', ConversationUser::class, 'user_id'),
    (new Extend\Routes('api'))
        ->get('/chenlizheme-private-messages/conversations', 'chenlizheme-private-messages.conversations.index', Controllers\ListConversationsController::class)
        ->get('/chenlizheme-private-messages/messages/{id}', 'chenlizheme-private-messages.messages.list', Controllers\ListMessagesController::class)
        ->post('/chenlizheme-private-messages/conversations', 'chenlizheme-private-messages.conversations.create', Controllers\CreateConversationController::class)
        ->post('/chenlizheme-private-messages/messages', 'chenlizheme-private-messages.messages.create', Controllers\CreateMessageController::class)
        ->post('/chenlizheme-private-messages/messages/typing', 'chenlizheme-private-messages.message.typing', Controllers\TypingPusherController::class)
        ->post('/chenlizheme-private-messages/messages/read', 'chenlizheme-private-messages.message.read', Controllers\ReadMessageController::class)
        ->delete('/chenlizheme-private-messages/messages{id}', 'chenlizheme-private-messages.messages.delete', Controllers\DeleteMessageController::class)
        //->patch('/messages/{id}', 'messages.update', Controllers\UpdateMessageController::class)
        //->delete('/messages/{id}', 'messages.delete', Controllers\DeleteMessageController::class)
        ->get('/chenlizheme-private-messages/conversations/{id}', 'chenlizheme-private-messages.conversations.show', Controllers\ShowConversationController::class),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('canMessage', function (ForumSerializer $serializer) {
            return $serializer->getActor()->can('startConversation');
        }),
    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('chenlizhemePrivateMessagesAllowUsersToReceiveEmailNotifications', function (ForumSerializer $serializer) {
            return $serializer->getActor()->can('chenlizheme-private-messages.allowUsersToReceiveEmailNotifications');
        }),

    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attribute('unreadMessages', function (CurrentUserSerializer $serializer) {
            return $serializer->getActor()->unread_messages;
        }),

    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesInitialInstalledVersion', 'chenlizheme-private-messages.initial_installed_version', function ($value) {
            return $value;
        }),

    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesReturnKey', 'chenlizheme-private-messages.return_key', function ($value) {
            return (bool)$value;
        }),

    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesEnableCustomColors', 'chenlizheme-private-messages.enable_custom_colors', function ($value) {
            return (bool)$value;
        }),
    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesRecipientBackgroundColor', 'chenlizheme-private-messages.recipient_background_color', function ($value) {
            return $value;
        }),
    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesSenderBackgroundColor', 'chenlizheme-private-messages.sender_background_color', function ($value) {
            return $value;
        }),
    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesRecipientTextColor', 'chenlizheme-private-messages.recipient_text_color', function ($value) {
            return $value;
        }),
    (new Extend\Settings())
        ->serializeToForum('chenlizhemePrivateMessagesSenderTextColor', 'chenlizheme-private-messages.sender_text_color', function ($value) {
            return $value;
        }),
    // (new Extend\Settings())
    //     ->serializeToForum('chenlizhemePrivateMessagesShowReadReceipts', 'chenlizheme-private-messages.show_read_receipts', function ($value) {
    //         return (bool)$value;
    //     }),
    // (new Extend\ApiSerializer(CurrentUserSerializer::class))
    //     ->hasMany('conversations', ConversationRecipientSerializer::class),

    // (new Extend\ApiController(Controller\ListUsersController::class))
    //     ->addInclude('conversations'),
    // (new Extend\ApiController(Controller\ShowUserController::class))
    //     ->addInclude('conversations'),
    // (new Extend\ApiController(Controller\CreateUserController::class))
    //     ->addInclude('conversations'),
    // (new Extend\ApiController(Controller\UpdateUserController::class))
    //     ->addInclude('conversations'),
    (new Extend\Notification())
        ->type(NewPrivateMessageBlueprint::class, MessageSerializer::class, ['email']),
    (new Extend\View)
        ->namespace('flarum-private-messages', __DIR__.'/views'),
];
