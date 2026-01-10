# Common Development Tasks

## Adding a New Feature

### 1. New Model
```bash
# Create migration
php artisan make:migration create_[table]_table

# Create model
php artisan make:model [ModelName]

# Define relationships in model
# Run migration
php artisan migrate
```

### 2. New Controller
Location: `operadora/app/Http/Controllers/`
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\YourModel;
use Auth;

class YourController extends Controller
{
    public function index()
    {
        $items = YourModel::all();
        return view('yourmodule.index', ['items' => $items]);
    }

    public function store(Request $request)
    {
        request()->validate([
            'field' => ['required', 'min:3'],
        ]);

        $item = new YourModel;
        $item->field = request('field');
        $item->save();

        return redirect()->route('your_route');
    }
}
```

### 3. New Routes
Add to `operadora/routes/web.php`:
```php
/*==============================================*/
/* YourModule Routes
/*==============================================*/
Route::get('/yourmodule', 'YourController@index')
    ->name('yourmodule_index')
    ->middleware('auth');
```

### 4. New Views
Create in `operadora/resources/views/yourmodule/`:
- `index.blade.php`
- `create.blade.php`
- `show.blade.php`
- `edit.blade.php`

Extend main layout:
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Your content -->
</div>
@endsection
```

## Adding a New Field to Existing Model

### 1. Create Migration
```bash
php artisan make:migration add_[field]_to_[table]_table
```

### 2. Edit Migration File
```php
public function up()
{
    Schema::table('your_table', function (Blueprint $table) {
        $table->string('new_field')->nullable()->after('existing_field');
    });
}

public function down()
{
    Schema::table('your_table', function (Blueprint $table) {
        $table->dropColumn('new_field');
    });
}
```

### 3. Run Migration
```bash
php artisan migrate
```

### 4. Update Model (if using $fillable)
```php
protected $fillable = ['existing_fields', 'new_field'];
```

### 5. Update Views/Controllers as needed

## Adding Permission Check

### 1. Add Method to User Model
```php
public function canDoSomething()
{
    if ($this->isAdmin()) return true;
    if ($this->role_id == 1) return true; // Operador
    return false;
}
```

### 2. Use in Controller
```php
if (!Auth::user()->canDoSomething()) {
    return redirect('/')->with('status', 'No tienes permisos');
}
```

### 3. Use in View
```blade
@if(Auth::user()->canDoSomething())
    <button>Action</button>
@endif
```

## Creating a PDF Report

### 1. Add Route
```php
Route::get('/printable/yourreport', 'ToursPDFController@printYourReport')
    ->name('printable_yourreport')
    ->middleware('auth');
```

### 2. Add Controller Method
```php
public function printYourReport()
{
    $data = YourModel::all();

    $pdf = PDF::loadView('pdf.yourreport', [
        'data' => $data
    ]);

    return $pdf->stream('report.pdf');
}
```

### 3. Create PDF View
`resources/views/pdf/yourreport.blade.php`

## Sending SMS

```php
use Twilio\Rest\Client;

$accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
$authToken = config('app.twilio')['TWILIO_AUTH_TOKEN'];

$client = new Client($accountSid, $authToken);

$client->messages->create(
    $phoneNumber,
    [
        'from' => '+12013790327',
        'body' => $messageBody
    ]
);
```

## Database Queries

### Get Reservations for Today
```php
$reservations = Reservation::where('date', Carbon::today()->toDateString())->get();
```

### Get Reservations by Departure and Date
```php
$reservations = $departure->reservations()
    ->where('date', $date)
    ->where('status', '<>', 4)  // Exclude cancelled
    ->get();
```

### Calculate Tour Capacity Used
```php
$sum = $departure->reservations()
    ->where('date', $date)
    ->sum('number_adults')
    + $departure->reservations()->where('date', $date)->sum('number_kids')
    + $departure->reservations()->where('date', $date)->sum('number_elders');
```

### Sales Report Query
```php
$totals = DB::table('reservations')
    ->join('tours', 'reservations.tour_id', 'tours.id')
    ->whereBetween('date', [$date1, $date2])
    ->selectRaw('tours.name, SUM(total)')
    ->groupBy('tours.name')
    ->get();
```

## Testing

### Run Seeder
```bash
php artisan db:seed --class=YourTableSeeder
```

### Fresh Database
```bash
php artisan migrate:fresh --seed
```

### Test User Login
- Email: `admin@admin.com`
- Password: (check UsersTableSeeder for current password)

## Debugging

### Laravel Debug
```php
dd($variable);        // Dump and die
dump($variable);      // Dump only
logger($message);     // Log to storage/logs
```

### Check Config
```php
dd(Config::get('app'));
dd(config('app.twilio'));
```

### Artisan Commands
```bash
php artisan route:list              # List all routes
php artisan config:cache            # Cache config
php artisan view:clear              # Clear view cache
php artisan cache:clear             # Clear app cache
```
