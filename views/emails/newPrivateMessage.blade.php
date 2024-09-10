{{ $translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.youHaveReceivedNewMessage', ['{user}' => $blueprint->user->display_name]) }}
<br />
{{ $blueprint->message->message }}
<br />
<a href="{{$url->to('forum')->route('neoncube-private-messages.messages', ['id' => $blueprint->message->conversation_id, 'number' => $blueprint->message->number])}}" target="_blank" style="padding: 0.5em 1em; background: #ADD445; color: #000000;">{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.viewMessage')}}</a>
<br />
<a href="{{$url->to('forum')->route('settings')}}">{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.manageEmailSettings')}}</a>