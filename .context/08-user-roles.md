# User Roles & Permissions

## Role Definitions

### Role IDs in Database
| ID | Type | Description |
|----|------|-------------|
| 1 | Operador | Tour operators with broad access |
| 2 | Recepcion | Hotel receptionists with limited access |
| 3 | Modulo | Point-of-sale modules with confirmation powers |

### Admin Flag
- `is_admin` boolean on User model
- Overrides all role restrictions
- Full system access

## Permission Methods (User Model)

### `isAdmin()`
```php
public function isAdmin()
{
    return $this->is_admin == true;
}
```

### `canCancel()`
Who can cancel reservations:
- Admins
- Role 1 (Operador)
- Role 2 (Recepcion)
```php
public function canCancel()
{
    if ($this->is_admin) return true;
    if ($this->role_id == 1 || $this->role_id == 2) return true;
    return false;
}
```

### `canOverSale()`
Who can sell beyond capacity limits:
- Admins
- Role 1 (Operador)
- Role 2 (Recepcion)

### `canReport()`
Who can access sales reports:
- Admins
- Role 1 (Operador)

### `canCreate()`
Who can create reservations:
- Role 3 (Modulo)
- Role 1 (Operador)

### `canConfirm()`
Who can confirm reservations:
- Admins
- Role 1 (Operador)
- Role 3 (Modulo)

### `canEdit()`
Who can edit reservations:
- Admins
- Role 1 (Operador)

### `globalSearch()`
Who can search all reservations:
- Admins
- Role 1 (Operador)

### `canCortesy()`
Who can create courtesy (free) reservations:
- Admins
- Role 3 (Modulo)
- Role 1 (Operador)

### `departureValidation()`
Who bypasses departure date validation:
- Returns false for: Admins, Modulo, Operador
- Returns true for: Recepcion (must validate)

## Role Type Checks

### `isReceptionist()`
```php
return $this->role->type == "Recepcion";
```

### `isModule()`
```php
return $this->role->type == "Modulo";
```

### `isOperador()`
```php
return $this->role->type == "Operador";
```

## Permission Matrix

| Action | Admin | Operador (1) | Recepcion (2) | Modulo (3) |
|--------|-------|--------------|---------------|------------|
| View Dashboard | Yes | Yes | Yes | Yes |
| Create Reservation | Yes | Yes | Yes | Yes |
| Edit Reservation | Yes | Yes | No | No |
| Cancel Reservation | Yes | Yes | Yes | No |
| Confirm Reservation | Yes | Yes | No | Yes |
| Create Courtesy | Yes | Yes | No | Yes |
| Access Reports | Yes | Yes | No | No |
| Global Search | Yes | Yes | No | No |
| Over-sell Tours | Yes | Yes | Yes | No |
| Manage Tours | Yes | Yes | No | No |
| Manage Users | Yes | No | No | No |
| Manage Hotels | Yes | Yes | No | No |
| Manage Zones | Yes | Yes | No | No |

## User Relationships

### Company Association
- Users belong to one company
- Affects which tours/data they can access

### Hotel Association
- Users can be associated with a hotel
- Used for receptionist assignments

### Commission Configuration
- Per-user, per-tour commission rates
- Stored in `commissions` table
- Rates for kids, adults, elders

## Auto-Confirmation Logic
When a reservation is created:
```php
if ($user->role->type == "Modulo" || $user->isAdmin()) {
    if ($payment_made == $total) {
        $reservation->confirmed = true;
    }
}
```

## View Restrictions
In controllers, role checks determine:
- Which tours are displayed
- Which reservations are visible
- Which actions are available

Example:
```php
if (Auth::user()->isAdmin()) {
    $tours = Tour::all()->where('company_id', $company->id);
} else if (Auth::user()->isModule() || Auth::user()->isOperador()) {
    $tours = Tour::all()->where('company_id', $company->id)
        ->where('name', 'Tour centro historico');
}
```

## Test Users (from Seeds)
| Username | Email | Role | Admin | Company |
|----------|-------|------|-------|---------|
| James | james@gmail.com | Operador | Yes | Operadora |
| admin | admin@admin.com | Operador | Yes | Operadora |
| jessy | jessy@example.com | Operador | Yes | Maxibus |
