# CLAUDE.md - AI Session Entry Point

> **Context Engineering Entry Point for Operadora Zacatecas**
> Read this file at the start of every session to understand the project context.

---

## Documentation Index

**Need to find the right context file?** Read `.context/00-doc-index.md` first.

The index provides:
- Task-based lookup (what do you need to do?)
- Feature-area guides (which files for reservations, tours, etc.)
- Session goal workflows (fixing bugs, adding features, understanding code)
- Quick decision tree for navigation

```
.context/00-doc-index.md  →  Your navigation guide to all documentation
```

---

## Quick Reference

| Item | Value |
|------|-------|
| **Project** | Operadora Zacatecas - Tour Reservation System |
| **Framework** | Laravel 5.7 |
| **PHP** | ^7.1.3 |
| **Database** | MySQL |
| **Language** | Spanish (UI), English/Spanish (code) |
| **Timezone** | America/Mexico_City |

## Project Purpose

Web-based tour reservation management system for tour operators in Zacatecas, Mexico. Manages bookings, seat assignments, hotel pickups, commissions, and sales reporting for two companies: **Operadora** and **Maxibus**.

## Directory Structure

```
operadorazacatecas.com/
├── CLAUDE.md                 # THIS FILE - Entry point
├── .context/                 # Context engineering documentation
│   ├── 00-doc-index.md       # ★ NAVIGATION GUIDE - Read this to find files
│   ├── 01-project-overview.md
│   ├── 02-tech-stack.md
│   ├── 03-architecture.md
│   ├── 04-database-schema.md
│   ├── 05-routes-api.md
│   ├── 06-coding-standards.md
│   ├── 07-business-domain.md
│   ├── 08-user-roles.md
│   └── 09-common-tasks.md
├── operadora/                # Laravel application
│   ├── app/                  # Models, Controllers, Middleware
│   ├── config/               # Configuration files
│   ├── database/             # Migrations, Seeds
│   ├── resources/views/      # Blade templates
│   └── routes/web.php        # Route definitions
├── public_html/              # Public assets
├── DB/                       # Database dumps
└── README.md                 # Original project README
```

## Core Entities

| Entity | Purpose | Key File |
|--------|---------|----------|
| **Reservation** | Customer booking | `app/Reservation.php`, `ReservationsController.php` |
| **Tour** | Tour product | `app/Tour.php`, `ToursController.php` |
| **Departure** | Tour time slot | `app/Departure.php`, `DepartureController.php` |
| **Seat** | Seat assignment | `app/Seat.php` |
| **Company** | Operadora or Maxibus | `app/Company.php` |
| **User** | System user with role | `app/User.php`, `UsersController.php` |
| **Hotel** | Pickup location | `app/Hotel.php`, `HotelsController.php` |
| **Zone** | Hotel grouping | `app/Zone.php`, `ZonesController.php` |

## User Roles

| Role ID | Name | Key Permissions |
|---------|------|-----------------|
| Admin | is_admin=true | Full access |
| 1 | Operador | Create, edit, cancel, reports |
| 2 | Recepcion | Create, cancel |
| 3 | Modulo | Create, confirm, courtesy |

## Key Business Logic

### Reservation Status
- 0: No payment
- 1: Commission only
- 2: Partial payment
- 3: Full payment
- 4: Cancelled

### Folio Format
`{COMPANY_3LETTERS}{PADDED_ID}` (e.g., `OPE0001234`)

### Bus Types
- Type 0: 61 seats
- Type 1: 52 seats

## Context Files Reference

For detailed information, read these files in `.context/`:

| Task | Read These Files |
|------|-----------------|
| Understanding the project | `01-project-overview.md` |
| Tech decisions | `02-tech-stack.md` |
| Code structure | `03-architecture.md` |
| Database changes | `04-database-schema.md` |
| Adding routes | `05-routes-api.md` |
| Writing code | `06-coding-standards.md` |
| Business rules | `07-business-domain.md` |
| Permissions | `08-user-roles.md` |
| Common tasks | `09-common-tasks.md` |

## Quick Commands

```bash
# Navigate to Laravel app
cd operadora

# Database operations
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Cache management
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# List routes
php artisan route:list
```

## Important Files for Feature Development

### Controllers (app/Http/Controllers/)
- `ReservationsController.php` - Core booking logic (~1000 lines)
- `ToursController.php` - Tour management
- `ToursViewsController.php` - Pickup views
- `ToursPDFController.php` - PDF generation
- `SalesController.php` - Reports

### Models (app/)
- `Reservation.php` - Main business entity
- `User.php` - User with permission methods
- `Tour.php` - Tour with departures
- `Departure.php` - Time slots with seats

### Routes
- `routes/web.php` - All routes (~250 lines)

### Views (resources/views/)
- `layouts/` - Base templates
- `reservations/` - Booking views
- `tours/` - Tour management
- `pdf/` - PDF templates

## Session Workflow

1. **Start**: Read this `CLAUDE.md` file
2. **Find docs**: Check `00-doc-index.md` to identify which context files you need
3. **Task-specific**: Read the relevant `.context/` files identified in step 2
4. **Implement**: Follow patterns in `06-coding-standards.md`
5. **Test**: Use commands above to verify

## Sub-Agent Usage (Gemini CLI)

For boilerplate code generation, use:
```bash
gemini -m gemini-2.5-pro "@.context/06-coding-standards.md @app/Http/Controllers/ReservationsController.php Generate [description]. Output code as text ONLY."
```

Context files to include:
- Always: `@.context/06-coding-standards.md`
- Models: `@.context/04-database-schema.md`
- Routes: `@.context/05-routes-api.md`
- Business logic: `@.context/07-business-domain.md`

## Notes

- UI is in Spanish
- Code comments are mixed Spanish/English
- Test with `admin@admin.com` (check seed for password)
- SMS via Twilio (requires env config)
- PDF via DomPDF
