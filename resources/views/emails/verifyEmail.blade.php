@component('mail::message')
    # Verify Email

    Tu código es {{ $pin }}

    No comparta su código único con nadie.

    Thanks,
    {{ config('app.name') }}
@endcomponent
