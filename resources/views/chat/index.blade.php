<chats
        title-image-url="/images/logo-no-bg.svg"
        :user='{!! auth()->user() !!}'
        :participants='{!! $participants !!}'
        :messages='{{ $messages ?? '' }}'
        chat-title="Общий чат"
>
</chats>