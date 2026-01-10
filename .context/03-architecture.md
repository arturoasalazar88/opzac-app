# Architecture Documentation

## Design Pattern
**MVC (Model-View-Controller)** - Standard Laravel architecture

## Application Structure

### Models (`app/`)
Core domain entities using Eloquent ORM:

| Model | Table | Purpose |
|-------|-------|---------|
| `User` | users | System users with roles |
| `Company` | companies | Tour companies (Operadora, Maxibus) |
| `Tour` | tours | Tour definitions with pricing |
| `Departure` | departures | Tour departure times/schedules |
| `Reservation` | reservations | Customer bookings |
| `Seat` | seats | Seat assignments per departure |
| `Hotel` | hotels | Pickup locations |
| `Zone` | zones | Hotel groupings for routes |
| `Role` | roles | User role definitions |
| `Payment` | payments | Payment transactions |
| `Commission` | commissions | User commission rates per tour |
| `Logger` | loggers | Activity logging |
| `Closure` | closures | Tour closures (unused) |
| `Project` | projects | Task management (secondary feature) |
| `Task` | tasks | Project tasks (secondary feature) |

### Controllers (`app/Http/Controllers/`)

| Controller | Responsibility |
|------------|----------------|
| `ReservationsController` | **Core**: Reservation CRUD, seat selection, SMS |
| `ToursController` | Tour CRUD, departure management |
| `ToursViewsController` | Pickup views, tour date displays |
| `ToursPDFController` | PDF generation for reports |
| `CompanyReservationsController` | Company-specific reservation flows |
| `DepartureController` | Departure schedules management |
| `HotelsController` | Hotel CRUD |
| `ZonesController` | Zone management |
| `UsersController` | User management, commissions |
| `SalesController` | Sales analytics and reporting |
| `SearchController` | Reservation search functionality |
| `PaymentController` | Payment processing |
| `LogsController` | Activity log viewing |
| `HomeController` | Dashboard |
| `TotalPassController` | External order integration |

### Middleware (`app/Http/Middleware/`)
- `Authenticate`: Auth guard
- `RedirectIfAuthenticated`: Guest redirects
- `VerifyCsrfToken`: CSRF protection
- `NoCache`: Cache prevention headers
- `TrimStrings`: Input sanitization
- `TrustProxies`: Proxy handling

### Service Providers (`app/Providers/`)
- `AppServiceProvider`: Bootstrap application
- `AuthServiceProvider`: Auth policies
- `RouteServiceProvider`: Route loading
- `EventServiceProvider`: Event listeners
- `BroadcastServiceProvider`: (disabled)

## Key Architectural Decisions

### 1. Multi-Company Support
Single database with `company_id` foreign keys. Users belong to one company, tours belong to one company.

### 2. Departure-Based Reservations
Tours have multiple departures (time slots). Reservations are made for specific departures, not tours directly.

### 3. Seat Selection
Two bus types: Type 0 (61 seats) and Type 1 (52 seats). Seats are tracked per departure+date combination.

### 4. Commission System
Users have per-tour commission rates for kids/adults/elders. Commissions calculated at reservation time.

### 5. Payment Status Tracking
```
Status 0: No payment
Status 1: Only commission paid
Status 2: Partial payment (more than commission, less than total)
Status 3: Full payment
Status 4: Cancelled
```

### 6. Folio Generation
Format: `{COMPANY_PREFIX}{PADDED_ID}` (e.g., `OPE0000123`)

## Authentication
- Laravel's built-in authentication (`Auth::routes()`)
- Session-based authentication
- `auth` middleware on most routes

## File Storage
- Local filesystem
- Tour images stored with `default.jpg` as fallback

## Request Flow
```
HTTP Request
    → Routes (web.php)
    → Middleware (auth, csrf)
    → Controller
    → Model (Eloquent)
    → View (Blade)
    → HTTP Response
```

## Error Handling
- `Whoops` for debug mode
- Custom exception handler (`app/Exceptions/Handler.php`)
