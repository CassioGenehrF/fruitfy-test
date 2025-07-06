@component('mail::message')
    # Hi {{ $name }},

    Your registration has been removed from our system.

    If this was a mistake, feel free to get in touch.

    Thanks,
    {{ config('app.name') }}
@endcomponent
