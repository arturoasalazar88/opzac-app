# Database Schema

## Entity Relationship Diagram (Conceptual)

```
Company (1) ──────< (N) Tour
    │                    │
    │                    └──< (N) Departure ──< (N) Seat
    │                              │
    └──< (N) User                  └──< (N) Reservation
              │                              │
              └──< (N) Commission            └──< (N) Payment
              └──< (N) Reservation
              └──< (N) Payment

Zone (1) ──< (N) Hotel ──< (N) Reservation
                 │
                 └──< (N) User

Role (1) ──< (N) User
```

## Tables Detail

### users
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
company_id          INT UNSIGNED NULLABLE
hotel_id            INT UNSIGNED DEFAULT 1
name                VARCHAR(255)
username            VARCHAR(255) UNIQUE
role_id             INT UNSIGNED
is_admin            BOOLEAN DEFAULT FALSE
comission_kids      DECIMAL(4,2) DEFAULT 0.0
comission_adults    DECIMAL(4,2) DEFAULT 0.0
comission_elders    DECIMAL(4,2) DEFAULT 0.0
email               VARCHAR(255) UNIQUE
email_verified_at   TIMESTAMP NULLABLE
password            VARCHAR(255)
remember_token      VARCHAR(100) NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### companies
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
name                VARCHAR(255)
description         TEXT NULLABLE
address             TEXT NULLABLE
owner               VARCHAR(255) NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### tours
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
company_id          INT UNSIGNED
name                VARCHAR(255)
horario             TIME NULLABLE
owner               VARCHAR(255) DEFAULT 'none'
cost_kids           INT DEFAULT 0
cost_adults         INT DEFAULT 0
cost_elders         INT DEFAULT 0
image               VARCHAR(255) DEFAULT 'default.jpg'
limit               INT DEFAULT 0
active              BOOLEAN DEFAULT TRUE
description         TEXT
closed              BOOLEAN DEFAULT FALSE
current             DATE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### departures
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
tour_id             INT UNSIGNED
horario             TIME
type                INT DEFAULT 0          -- 0=61 seats, 1=52 seats
closed              BOOLEAN DEFAULT FALSE
date_closed         DATE NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### reservations
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
status              TINYINT DEFAULT 0      -- 0:none, 1:commission, 2:partial, 3:full, 4:cancelled
confirmed           BOOLEAN DEFAULT FALSE
client              VARCHAR(255)
client_email        VARCHAR(255) NULLABLE
telephone           VARCHAR(255)
procedence          VARCHAR(255) NULLABLE
room                INT NULLABLE
date                DATE
number_kids         INT DEFAULT 0
number_adults       INT DEFAULT 0
number_elders       INT DEFAULT 0
comission_kids      DECIMAL(6,2) DEFAULT 0
comission_adults    DECIMAL(6,2) DEFAULT 0
comission_elders    DECIMAL(6,2) DEFAULT 0
total_kids          DECIMAL(6,2) DEFAULT 0
total_adults        DECIMAL(6,2) DEFAULT 0
total_elders        DECIMAL(6,2) DEFAULT 0
price_kids          DECIMAL(6,2) DEFAULT 0
price_adults        DECIMAL(6,2) DEFAULT 0
price_elders        DECIMAL(6,2) DEFAULT 0
total               DECIMAL(6,2)
first_payment       DECIMAL(6,2) DEFAULT 0
total_commission    DECIMAL(6,2)
remaining           DECIMAL(6,2)
actual_pay          DECIMAL(6,2)
payment_method      VARCHAR(255)           -- efectivo, tarjeta, citypass, cortesia, cancelada
credit_numbers      VARCHAR(255) DEFAULT 'XXXX'
citypass            VARCHAR(255) NULLABLE
user_id             INT UNSIGNED
tour_id             INT UNSIGNED NULLABLE
departure_id        INT UNSIGNED
hotel_id            INT UNSIGNED
folio               VARCHAR(255)
comments            TEXT NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### seats
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
departure_id        INT UNSIGNED
date                DATE
seat                INT
reservation_id      INT UNSIGNED
type                INT DEFAULT 0
created_at          TIMESTAMP
updated_at          TIMESTAMP

UNIQUE(departure_id, date, seat)
```

### hotels
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
name                VARCHAR(255)
key                 VARCHAR(255) DEFAULT '--'
zone_id             INT UNSIGNED
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### zones
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
name                VARCHAR(255)
number              VARCHAR(255)
closure             INT DEFAULT 5
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### roles
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
type                VARCHAR(255)           -- 'Operador', 'Recepción', 'Módulo'
administrator       BOOLEAN DEFAULT FALSE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### payments
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
user_id             INT UNSIGNED
reservation_id      INT UNSIGNED
payment             DECIMAL(6,2)
payment_confirm     DECIMAL(6,2) NULLABLE
is_confirm          BOOLEAN DEFAULT FALSE
user_confirm        VARCHAR(255) NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### commissions
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
user_id             INT UNSIGNED
tour_id             INT UNSIGNED
kids                DECIMAL(6,2) DEFAULT 0
adults              DECIMAL(6,2) DEFAULT 0
elders              DECIMAL(6,2) DEFAULT 0
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### loggers
```sql
id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
controller          VARCHAR(255)
method              VARCHAR(255)
action              VARCHAR(255)
parameter           VARCHAR(255)
user                VARCHAR(255)
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

## Eloquent Relationships

### User
- `belongsTo` Role
- `belongsTo` Company
- `belongsTo` Hotel
- `hasMany` Reservation
- `hasMany` Payment
- `hasMany` Commission

### Company
- `hasMany` User
- `hasMany` Tour
- `hasMany` Zone

### Tour
- `belongsTo` Company
- `hasMany` Departure
- `hasMany` Reservation

### Departure
- `belongsTo` Tour
- `hasMany` Reservation
- `hasMany` Seat

### Reservation
- `belongsTo` User
- `belongsTo` Tour
- `belongsTo` Departure
- `belongsTo` Hotel
- `hasMany` Payment
- `hasMany` Seat

### Hotel
- `belongsTo` Zone
- `hasMany` User

### Zone
- `hasMany` Hotel
- `belongsTo` Company

### Role
- `hasMany` User
