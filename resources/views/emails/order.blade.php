@component('mail::message')
    # Order Notification

    Hola {{ $name }},

    Orden ID : {{$orderId}}
    {{$message}}

    Gracias,
    {{ config('app.name') }}
@endcomponent
