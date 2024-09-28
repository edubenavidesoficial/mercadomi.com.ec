@component('mail::message')
    # Reset Password

    Tu código es {{$pin}}

    No comparta su código único con nadie.
    Hiciste una solicitud para restablecer tu contraseña. Por favor
    descarta si este no fueras tú.

    Gracias,
    {{ config('app.name') }}
@endcomponent
