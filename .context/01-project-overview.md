# Project Overview: Operadora Zacatecas

## Application Name
**Operadora** - Tour Reservation Management System

## Version
1.1.1

## Purpose
Web-based tour reservation and management system for tour operators in Zacatecas, Mexico. The system manages tour bookings, seat reservations, hotel pickups, commissions, payments, and sales reporting for two main tour companies: **Operadora** and **Maxibus**.

## Business Domain
Tourism/Travel industry - specifically tour operator management for city tours and excursions.

## Key Features
1. **Tour Management**: Create, edit, and manage tours with pricing (kids/adults/elders)
2. **Reservation System**: Full reservation workflow with seat selection
3. **Departure Scheduling**: Multiple departure times per tour with capacity management
4. **Hotel Integration**: Hotel zones for pickup coordination
5. **Payment Processing**: Track payments, commissions, and balances
6. **SMS Notifications**: Twilio integration for reservation confirmations
7. **PDF Generation**: Printable reports and reservation tickets
8. **Sales Reporting**: Revenue analytics by tour, user, hotel, and date
9. **Role-Based Access**: Different permissions for operators, receptionists, and modules

## Main Companies
- **Operadora**: Primary tour operator (Company ID: 1)
- **Maxibus**: Secondary tour operator (Company ID: 2)

## Primary Users
- **Administrators**: Full system access
- **Operadores** (Operators): Tour management, reservations, cancellations
- **Recepcionistas** (Receptionists): Create reservations, limited access
- **Modulos** (Modules): Point-of-sale operations, confirm payments

## Directory Structure
```
operadorazacatecas.com/
├── operadora/           # Laravel application
│   ├── app/            # Application code
│   ├── config/         # Configuration files
│   ├── database/       # Migrations and seeds
│   ├── resources/      # Views and assets
│   └── routes/         # Route definitions
├── public_html/        # Public assets (moved from operadora/public)
├── DB/                 # Database dumps
└── CLAUDE.md           # AI assistant entry point
```

## Timezone
America/Mexico_City

## Language
Spanish (UI and business logic), English (code comments partial)
