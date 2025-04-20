{{ $translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.youHaveReceivedNewMessage', ['{user}' => $blueprint->user->display_name]) }}

-----------------------
{{ $blueprint->message->message }}
-----------------------

{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.viewMessage')}}: {{$url->to('forum')->route('neoncube-private-messages.messages', ['id' => $blueprint->message->conversation_id, 'number' => $blueprint->message->number])}}" 

{{$translator->trans('neoncube-private-messages.forum.notifications.email.new_private_message.manageEmailSettings')}}: {{$url->to('forum')->route('settings')}}
