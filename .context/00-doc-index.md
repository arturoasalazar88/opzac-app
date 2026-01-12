# Documentation Index

> **Quick reference to find the right context file for your task**

---

## By Task Type

### Understanding the Project
| Question | Read |
|----------|------|
| What does this app do? | `01-project-overview.md` |
| Who uses this system? | `01-project-overview.md`, `08-user-roles.md` |
| What companies are involved? | `01-project-overview.md` |
| What's the directory structure? | `01-project-overview.md` |

### Technical Setup & Stack
| Question | Read |
|----------|------|
| What framework/version? | `02-tech-stack.md` |
| What packages are installed? | `02-tech-stack.md` |
| How to configure environment? | `02-tech-stack.md` |
| What PHP extensions needed? | `02-tech-stack.md` |
| How to run artisan commands? | `02-tech-stack.md` |
| How to run with Docker? | `02-tech-stack.md` (Docker section) |
| Docker compatibility notes? | `02-tech-stack.md` (Composer 1.x, MariaDB, Mailpit) |

### Code Architecture
| Question | Read |
|----------|------|
| How is code organized? | `03-architecture.md` |
| What models exist? | `03-architecture.md`, `04-database-schema.md` |
| What controllers handle what? | `03-architecture.md` |
| What middleware is used? | `03-architecture.md` |
| How does request flow work? | `03-architecture.md` |

### Database Work
| Question | Read |
|----------|------|
| What tables exist? | `04-database-schema.md` |
| What are the column definitions? | `04-database-schema.md` |
| How are models related? | `04-database-schema.md` |
| How to add a new field? | `09-common-tasks.md` |
| How to create a migration? | `09-common-tasks.md` |

### Routes & Endpoints
| Question | Read |
|----------|------|
| What routes exist? | `05-routes-api.md` |
| How to add a new route? | `05-routes-api.md`, `09-common-tasks.md` |
| What controller handles X route? | `05-routes-api.md` |
| What's the URL for X action? | `05-routes-api.md` |

### Writing Code
| Question | Read |
|----------|------|
| What naming conventions to use? | `06-coding-standards.md` |
| How to write a controller? | `06-coding-standards.md` |
| How to write a model? | `06-coding-standards.md` |
| How to validate input? | `06-coding-standards.md` |
| How to write queries? | `06-coding-standards.md` |
| How to return responses? | `06-coding-standards.md` |

### Business Logic
| Question | Read |
|----------|------|
| How do reservations work? | `07-business-domain.md` |
| How is pricing calculated? | `07-business-domain.md` |
| How do commissions work? | `07-business-domain.md` |
| What are payment statuses? | `07-business-domain.md` |
| How is folio generated? | `07-business-domain.md` |
| How does seat selection work? | `07-business-domain.md` |
| How do SMS notifications work? | `07-business-domain.md` |

### Permissions & Access
| Question | Read |
|----------|------|
| What roles exist? | `08-user-roles.md` |
| Who can do what? | `08-user-roles.md` |
| How to check permissions? | `08-user-roles.md` |
| How to add a new permission? | `08-user-roles.md`, `09-common-tasks.md` |

### Development Tasks
| Question | Read |
|----------|------|
| How to add a new feature? | `09-common-tasks.md` |
| How to create a PDF report? | `09-common-tasks.md` |
| How to send SMS? | `09-common-tasks.md` |
| How to debug? | `09-common-tasks.md` |
| Common database queries? | `09-common-tasks.md` |

---

## By Feature Area

### Reservations Feature
```
Primary:   07-business-domain.md (logic)
           05-routes-api.md (endpoints)
Secondary: 04-database-schema.md (reservations, seats, payments tables)
           06-coding-standards.md (patterns)
Code:      app/Http/Controllers/ReservationsController.php
           app/Reservation.php
           resources/views/reservations/
```

### Tours Feature
```
Primary:   07-business-domain.md (logic)
           05-routes-api.md (endpoints)
Secondary: 04-database-schema.md (tours, departures tables)
Code:      app/Http/Controllers/ToursController.php
           app/Tour.php
           app/Departure.php
           resources/views/tours/
```

### Users & Permissions Feature
```
Primary:   08-user-roles.md (permissions)
Secondary: 04-database-schema.md (users, roles, commissions tables)
Code:      app/User.php (permission methods)
           app/Http/Controllers/UsersController.php
           resources/views/users/
```

### Hotels & Zones Feature
```
Primary:   04-database-schema.md (hotels, zones tables)
           05-routes-api.md (endpoints)
Code:      app/Hotel.php
           app/Zone.php
           app/Http/Controllers/HotelsController.php
           app/Http/Controllers/ZonesController.php
```

### Sales & Reports Feature
```
Primary:   07-business-domain.md (report logic)
           05-routes-api.md (endpoints)
Code:      app/Http/Controllers/SalesController.php
           app/Http/Controllers/ToursPDFController.php
           resources/views/sales/
           resources/views/pdf/
```

### Pickup Schedules Feature
```
Primary:   05-routes-api.md (pickup routes)
           07-business-domain.md (zones/scheduling)
Code:      app/Http/Controllers/ToursViewsController.php
           resources/views/pickups/
```

---

## By Session Goal

### "I need to fix a bug in..."
1. Start with `05-routes-api.md` to find the route
2. Read `03-architecture.md` to understand flow
3. Check `07-business-domain.md` for business rules
4. Reference `06-coding-standards.md` for patterns

### "I need to add a new feature..."
1. Read `09-common-tasks.md` for step-by-step guide
2. Check `03-architecture.md` for where to add code
3. Reference `04-database-schema.md` if DB changes needed
4. Follow `06-coding-standards.md` for conventions

### "I need to understand how X works..."
1. Check `07-business-domain.md` for business logic
2. Read `03-architecture.md` for code structure
3. Reference `05-routes-api.md` for entry points

### "I need to add a new report..."
1. Read `09-common-tasks.md` (PDF section)
2. Check `07-business-domain.md` for data logic
3. Reference existing code in `ToursPDFController.php`

### "I need to modify permissions..."
1. Read `08-user-roles.md` completely
2. Check `09-common-tasks.md` for adding permissions
3. Modify `app/User.php` permission methods

---

## File Summary

| File | Lines | Purpose |
|------|-------|---------|
| `00-doc-index.md` | - | THIS FILE - Navigation guide |
| `01-project-overview.md` | ~80 | What the project is |
| `02-tech-stack.md` | ~90 | Technologies used |
| `03-architecture.md` | ~140 | Code organization |
| `04-database-schema.md` | ~250 | Database structure |
| `05-routes-api.md` | ~350 | All routes |
| `06-coding-standards.md` | ~180 | How to write code |
| `07-business-domain.md` | ~200 | Business rules |
| `08-user-roles.md` | ~150 | Permissions |
| `09-common-tasks.md` | ~200 | How-to guides |

---

## Quick Decision Tree

```
What do you need?
│
├─► Understand something
│   ├─► Project overview → 01-project-overview.md
│   ├─► Technical stack → 02-tech-stack.md
│   ├─► Code structure → 03-architecture.md
│   ├─► Database → 04-database-schema.md
│   ├─► Business rules → 07-business-domain.md
│   └─► Permissions → 08-user-roles.md
│
├─► Find something
│   ├─► A route/endpoint → 05-routes-api.md
│   ├─► A table/column → 04-database-schema.md
│   └─► A controller → 03-architecture.md
│
└─► Build something
    ├─► Write code → 06-coding-standards.md
    ├─► Add feature → 09-common-tasks.md
    └─► Add permission → 08-user-roles.md + 09-common-tasks.md
```
