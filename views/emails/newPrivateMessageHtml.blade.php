{{ $translator->trans('chenlizheme-private-messages.forum.notifications.email.new_private_message.youHaveReceivedNewMessage', ['{user}' => $blueprint->user->display_name]) }}

<p>
    {{ $blueprint->message->message }}
</p>

<p>
    <a href="{{$url->to('forum')->route('chenlizheme-private-messages.messages', ['id' => $blueprint->message->conversation_id, 'number' => $blueprint->message->number])}}" target="_blank" style="padding: 0.5em 1em; background: {{$blueprint->primaryColor}}; color: {{$blueprint->secondaryColor}};">{{$translator->trans('chenlizheme-private-messages.forum.notifications.email.new_private_message.viewMessage')}}</a>
</p>

<p>
    <a href="{{$url->to('forum')->route('settings')}}" target="_blank">{{$translator->trans('chenlizheme-private-messages.forum.notifications.email.new_private_message.manageEmailSettings')}}</a>
</p>