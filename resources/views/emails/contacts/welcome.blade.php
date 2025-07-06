@component('mail::message')
    # Welcome, {{ $name }}! 🍍

    Thank you for joining our contact list.

    We're happy to have you with us. If you have any questions, feel free to reply to this message.

    @component('mail::button', ['url' => config('app.url')])
        Visit Fruitfy
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
