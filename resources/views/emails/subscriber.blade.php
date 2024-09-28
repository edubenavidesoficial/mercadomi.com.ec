@component('mail::message')
    # Subscriber Notification

    Hola,

    Tema : {{ $title }}
    {{ $message }}

    Gracias,
    {{ config('app.name') }}
@endcomponent
