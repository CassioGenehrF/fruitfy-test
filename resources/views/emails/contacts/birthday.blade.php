@component('mail::message')
    # Happy Birthday, {{ $contact->name }}! 🎉

    We wish you a joyful and successful year ahead.

    @component('mail::button', ['url' => url('/')])
        Visit our site
    @endcomponent

    Best wishes,
    {{ config('app.name') }}
@endcomponent
