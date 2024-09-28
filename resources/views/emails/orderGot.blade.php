@component('mail::message')
    # Order Notification

    Orden ID : {{$orderId}}
    {{$message}}

    Gracias,
    {{ config('app.name') }}
@endcomponent
