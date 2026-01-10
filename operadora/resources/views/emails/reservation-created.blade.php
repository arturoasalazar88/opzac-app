@component('mail::message')
## Nueva Reservación Creada

Está recibiendo este mensaje ya que se ha realizado una reserva a su nombre
con esta dirección de correo electrónico.

Como complemento de nuestro servicio se le hace la notificación del **Folio** asignado
a su reservación para el tour **{{ $reservation->departure->tour->name }}**

### FOLIO

**{{ $reservation->folio }}**

### Información general

- **Tour** {{ $reservation->departure->tour->name }}
- **Horario** {{ $reservation->departure->horario }}
- **Fecha** {{ $reservation->date }}
- **Nombre** {{ $reservation->client }}
- **Teléfono** {{ $reservation->telephone }}

### Información del boletaje

- **Niños** {{ $reservation->number_kids }}
- **Adultos** {{ $reservation->number_adults }}
- **INSEN** {{ $reservation->number_elders }}
- **Total** {{ $reservation->total }}
- **Su pago** {{ $reservation->actual_pay }}
- **Restante** {{ $reservation->remaining }}

@if ($reservation->departure->tour->company->name == "Maxibus")
### Información de los asientos
@foreach ($reservation->seats as $key => $seat)
- {{ $seat->seat }}
@endforeach
@endif

Visítanos en Operadora
@component('mail::button', ['url' => "https://maps.app.goo.gl/czLQtk3s4EM54bht5", 'color' => 'success'])
¡Cómo llegar!
@endcomponent

A sus ordenes,<br>
{{ config('app.name') }}
@endcomponent
