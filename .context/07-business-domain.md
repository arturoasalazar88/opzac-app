# Business Domain Documentation

## Core Business Entities

### Company
Tour operator company. System supports multiple companies (multi-tenant within same database).
- **Operadora**: Primary tour operator in Zacatecas
- **Maxibus**: Secondary tour operator

### Tour
A tour product with defined pricing and capacity.
- Has pricing for three passenger types: kids, adults, elders
- Has a capacity limit (number of passengers)
- Can be active/inactive
- Can be closed/open for specific dates
- Belongs to one company

### Departure
A specific time slot for a tour.
- Multiple departures per tour (e.g., 9:00 AM, 11:00 AM, 2:00 PM)
- Has a bus type determining capacity:
  - Type 0: 61 seats
  - Type 1: 52 seats
- Can be closed/activated independently

### Reservation
A customer booking for a tour departure on a specific date.
- Contains client information (name, email, phone, hotel room)
- Tracks number of passengers by type (kids, adults, elders)
- Calculates totals and commissions
- Has a unique folio number
- Links to departure, hotel, and user who created it

### Seat
Individual seat assignment for a reservation.
- Ensures no double-booking (unique constraint on departure+date+seat)
- Tracks seat number and bus type

### Zone
Geographic grouping of hotels for pickup route optimization.
- Has a closure time (minutes before tour departure for last pickup)
- Groups hotels together for scheduling

### Hotel
Accommodation property where customers are picked up.
- Belongs to a zone
- Has a short key/code for identification

## Business Rules

### Reservation Creation
1. Validate client data and passenger counts
2. Check tour capacity (sum of existing reservations + new tickets < tour limit)
3. Calculate pricing based on tour costs
4. Calculate commission based on user's commission rates for the tour
5. Generate unique folio: `{COMPANY_3LETTERS}{PADDED_ID}` (e.g., OPE0000123)
6. Set status based on payment amount
7. Optionally send SMS confirmation via Twilio

### Payment Status Logic
```
Status 0: No payment recorded
Status 1: actual_pay == total_commission (commission only)
Status 2: actual_pay > total_commission AND actual_pay < total (partial)
Status 3: actual_pay >= total (fully paid)
Status 4: Cancelled
```

### Confirmation Logic
- Reservations made by "Modulo" role users are auto-confirmed if fully paid
- Other reservations require manual confirmation
- Admin or authorized users can confirm

### Cancellation Logic
- Cancelled reservations get status = 4
- Payment method set to "cancelada"
- Associated seats are deleted (freed up)
- Only admins, the creating user, or operators can cancel

### Commission Calculation
```php
commission_total = (number_kids * user_commission_kids) +
                   (number_adults * user_commission_adults) +
                   (number_elders * user_commission_elders)
```
Commissions are per-tour, per-user defined.

### Payment Methods
- `efectivo`: Cash
- `tarjeta`: Credit/debit card
- `citypass`: Tourist pass (requires unique citypass code, no charge)
- `cortesia`: Courtesy (no charge)
- `cancelada`: Cancelled

### Citypass Validation
- Each citypass code can only be used once
- System checks for duplicate citypass codes before accepting

### Seat Selection (Maxibus)
- Seats are visually selected from a bus layout
- Unique constraint prevents double-booking
- Seats are date-specific (same seat can be booked on different dates)
- Transaction rollback if seat conflict occurs

### Folio Generation
```php
$company = substr($tour->company->name, 0, 3);  // "OPE" or "MAX"
$id = $last_reservation_id + 1;
$folio = strtoupper($company) . str_pad($id, 7, '0', STR_PAD_LEFT);
// Result: "OPE0001234"
```

## User Workflows

### Receptionist Workflow
1. Select company
2. Select tour
3. Select departure time
4. Select date
5. Fill reservation form
6. Select seats (if Maxibus)
7. Collect payment
8. System sends SMS (optional)

### Operator Workflow
Same as receptionist plus:
- Can cancel reservations
- Can view all reservations
- Can access pickup schedules

### Module (Point-of-Sale) Workflow
- Can confirm reservations
- Auto-confirmation when full payment received
- Can create courtesy reservations

### Admin Workflow
Full access to all features:
- User management
- Tour management
- Commission configuration
- Sales reporting
- All cancellations

## Pickup Scheduling
Tours have pickup schedules organized by:
1. **By Zone**: All hotels in a zone with their times
2. **By Hour**: All pickups at a specific time
3. **By Hotel**: Specific hotel's schedule
4. **By Tour**: All pickups for a specific tour

These generate printable PDF reports for drivers.

## Sales Reporting
Reports available:
- Sales by tour (with date range)
- Sales by user (top 10)
- Sales by hotel (top 10)
- Sales by date
- Confirmed vs unconfirmed ratio

## SMS Notifications
Via Twilio when reservation created:
```
COMO LLEGAR -> [bit.ly link]
RESERVACION [client_name],
FOLIO [folio_number],
TOUR [tour_name]
HORARIO [departure_time].
PAGADO $[first_payment].
TEL: 4929240050
RESTO A PAGAR: ($[remaining])
```
