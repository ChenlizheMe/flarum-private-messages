{{ $translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.youHaveReceivedNewMessage', ['{user}' => $blueprint->user->display_name]) }}
<p style="margin-left: 20px">
    {{ $blueprint->message->message }}
</p>

<p>
    <a href="{{$url->to('forum')->route('neoncube-private-messages.messages', ['id' => $blueprint->message->conversation_id, 'number' => $blueprint->message->number])}}" target="_blank" style="padding: 0.5em 1em; border: solid 1px black; outline: solid 1px white; border-radius: 5px;">{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.viewMessage')}}</a>
    &nbsp;&nbsp;
    <a href="{{$url->to('forum')->route('settings')}}" target="_blank" style="padding: 0.5em 1em; border: solid 1px black; outline: solid 1px white; border-radius: 5px;">{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.manageEmailSettings')}}</a>
</p>
