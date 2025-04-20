<?php

namespace ChenlizheMe\FlarumPrivateMessages\Api\Controllers;


use Flarum\Api\Controller\AbstractListController;
use Tobscure\JsonApi\Document;
use Flarum\User\Exception\PermissionDeniedException;
use Illuminate\Support\Arr;
use ChenlizheMe\FlarumPrivateMessages\Api\Serializers\MessageSerializer;
use ChenlizheMe\FlarumPrivateMessages\Conversation;
use ChenlizheMe\FlarumPrivateMessages\Message;
use Psr\Http\Message\ServerRequestInterface;

class ListMessagesController extends AbstractListController
{
    public $serializer = MessageSerializer::class;

    public $include = ['user'];

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $conversationId = Arr::get($request->getQueryParams(), 'id');
        $actor = $request->getAttribute('actor');
        $limit = $this->extractLimit($request);
        $offset = $request->getQueryParams()['offset'];

        $conversation = Conversation::find($conversationId);

        if (!$conversation->recipients()->where('user_id', $actor->id)->exists()) {
            throw new PermissionDeniedException;
        }

        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return $messages;
    }
}
