<?php

namespace ChenlizheMe\FlarumPrivateMessages\Api\Controllers;

use Flarum\Api\Controller\AbstractCreateController;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use ChenlizheMe\FlarumPrivateMessages\Api\Serializers\ConversationRecipientSerializer;
use ChenlizheMe\FlarumPrivateMessages\Commands\ReadMessage;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;


class ReadMessageController extends AbstractCreateController
{
    public $serializer = ConversationRecipientSerializer::class;

    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');

        $conversationRec = $this->bus->dispatch(
            new ReadMessage($actor, $request->getParsedBody())
        );

        return $conversationRec;
    }
}
