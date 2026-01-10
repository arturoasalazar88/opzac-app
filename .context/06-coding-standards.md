# Coding Standards & Conventions

## PHP/Laravel Conventions

### Naming Conventions
```php
// Classes: PascalCase
class ReservationsController
class Reservation

// Methods: camelCase
public function storeWithSeats()
public function indexCompany()

// Variables: snake_case or camelCase (mixed in codebase)
$cost_kids = 100;
$totalComission = 50;

// Database columns: snake_case
$table->string('client_email');
$table->integer('number_kids');

// Routes: kebab-case with underscores in names
Route::get('/reservation/cancel/{reservation}')
    ->name('reservation_cancel')
```

### Controller Patterns
```php
// Resource methods follow Laravel conventions
public function index()      // List all
public function create()     // Show create form
public function store()      // Save new record
public function show($id)    // Show single record
public function edit($id)    // Show edit form
public function update($id)  // Update record
public function destroy($id) // Delete record

// Custom methods
public function selectSeat()
public function storeWithSeats()
public function confirm()
public function cancel()
```

### Model Patterns
```php
// Use $guarded for mass assignment (preferred in this codebase)
protected $guarded = [];

// Or $fillable for explicit whitelist
protected $fillable = ['controller', 'method', 'action', 'parameter', 'user'];

// Relationships as methods
public function reservations()
{
    return $this->hasMany(Reservation::class);
}

public function company()
{
    return $this->belongsTo(Company::class);
}
```

### Validation Pattern
```php
request()->validate([
    'client' => ['required', 'min:4'],
    'hotel_id' => ['required'],
    'date' => ['required'],
    'number_kids' => ['required', 'numeric'],
    'actual_pay' => ['required', 'numeric'],
    'payment_method' => ['required'],
]);
```

### Query Patterns
```php
// Eloquent preferred
$reservations = Reservation::orderBy('created_at', 'desc')->paginate(50);
$tours = Tour::all()->where('company_id', $company->id);

// Query Builder for complex queries
$tours = DB::table('reservations')
    ->join('tours', 'reservations.tour_id', 'tours.id')
    ->whereBetween('date', [$date1, $date2])
    ->selectRaw('tours.name, SUM(total)')
    ->groupBy('tours.name')
    ->get();
```

## View Conventions

### Blade Templates
```
resources/views/
├── layouts/
│   ├── app.blade.php         # Main layout
│   └── select-seat.blade.php
├── reservations/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
└── [module]/
    └── [action].blade.php
```

### Blade Syntax
```blade
{{-- Comments --}}
{{ $variable }}           {{-- Escaped output --}}
{!! $html !!}            {{-- Raw HTML --}}
@if, @elseif, @else, @endif
@foreach, @endforeach
@auth, @endauth
@include('partial.name')
@extends('layouts.app')
@section('content')
@yield('content')
```

## Authentication Patterns
```php
// Middleware
->middleware('auth')

// In controllers
use Auth;
Auth::user()->id
Auth::user()->isAdmin()
Auth::user()->role->type

// Permission checks
if (Auth::user()->isAdmin()) { }
if (Auth::user()->canCancel()) { }
if (Auth::user()->role_id == 1) { }
```

## Date Handling
```php
use Carbon\Carbon;

// Current date
Carbon::now()
Carbon::now()->toDateString()     // 2024-01-15
Carbon::today()->toDateString()

// Parsing
Carbon::parse($date)->toDateString()
```

## Response Patterns
```php
// View responses
return view('reservations.index', [
    'reservations' => $reservations,
]);

// Redirects
return redirect()->route('reservations_show', ['reservation' => $reservation])
    ->with('status', 'Success message');

return redirect()->back()->with('status', 'Error message');

// JSON (AJAX)
return response()->json([
    'status' => '0',
    'price_kids' => $price_kids,
]);
```

## Error Messages
- Spanish language for user-facing messages
- Flash messages via `->with('status', 'message')`
- Bootstrap alert classes: 'success', 'danger', 'warning'

## Code Comments
- Mix of Spanish and English
- PHPDoc on some methods
- Inline comments for business logic

## Import Conventions
```php
use Illuminate\Http\Request;
use App\Reservation;
use App\Tour;
use Carbon\Carbon;
use Auth;
use DB;
```

## Test Data Passwords
- Default password for seeds: `qwerty`
- Admin password: varies in seeds
