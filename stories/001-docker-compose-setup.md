# Story: Docker Compose Setup for Operadora Zacatecas

## Overview
Create a Docker Compose configuration to run the Operadora Zacatecas Laravel application locally for development purposes.

---

## Technical Requirements

### PHP Application Container
- **PHP Version**: 7.1.3+ (use `php:7.4-fpm` for stability with Laravel 5.7)
- **Required PHP Extensions**:
  - OpenSSL
  - PDO / PDO_MySQL
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - GD (for DomPDF)
  - Zip

### Web Server Container
- **Nginx** or **Apache**
- Configure to serve from `operadora/public/`
- Handle PHP-FPM upstream

### Database Container
- **MySQL 5.7** (compatible with Laravel 5.7)
- Default credentials:
  - Database: `operadora_db`
  - Username: `operadora`
  - Password: `secret`
  - Root Password: `rootsecret`
- Port: 3306
- Persistent volume for data

### Node.js Container (Optional - for asset compilation)
- **Node.js 10.x or 12.x** (compatible with Laravel Mix 4.x)
- Used for `npm run dev` / `npm run production`

---

## Composer Dependencies

```json
{
    "php": "^7.1.3",
    "barryvdh/laravel-dompdf": "^0.8.4",
    "fideloper/proxy": "^4.0",
    "laravel/framework": "5.7.*",
    "laravel/tinker": "^1.0",
    "twilio/sdk": "^5.32"
}
```

## NPM Dependencies

```json
{
    "axios": "^0.18",
    "bootstrap": "^4.0.0",
    "cross-env": "^5.1",
    "jquery": "^3.2",
    "laravel-mix": "^4.0.7",
    "lodash": "^4.17.5",
    "popper.js": "^1.12",
    "resolve-url-loader": "^2.3.1",
    "sass": "^1.15.2",
    "sass-loader": "^7.1.0",
    "vue": "^2.5.17"
}
```

---

## Environment Configuration

### Use Existing .env File

The Docker setup should mount and use the existing `.env` file located at `operadora/.env`. This ensures:
- Consistent configuration between local and containerized environments
- No need to maintain separate environment files
- Existing credentials and settings are preserved

**Important**: Update these values in the existing `.env` for Docker compatibility:

```env
# Change DB_HOST from 127.0.0.1 to the mysql service name
DB_HOST=mysql

# Change REDIS_HOST if using Redis
REDIS_HOST=redis

# Change MAIL_HOST if using Mailhog
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Volume Mount for .env

```yaml
volumes:
  - ./operadora/.env:/var/www/html/.env
```

Or mount the entire operadora directory (recommended):

```yaml
volumes:
  - ./operadora:/var/www/html
```

This will automatically include the `.env` file along with all application code.

---

## Directory Structure to Create

```
operadorazacatecas.com/
├── docker/
│   ├── nginx/
│   │   └── default.conf       # Nginx site configuration
│   ├── php/
│   │   └── Dockerfile         # PHP-FPM with extensions
│   └── mysql/
│       └── init.sql           # Optional: Initial database setup
├── docker-compose.yml         # Main compose file
└── operadora/
    └── .env                   # EXISTING - Mount this file into containers
```

---

## Services to Include

### 1. `app` (PHP-FPM)
- Build from custom Dockerfile
- Install Composer
- Install required PHP extensions
- Mount `./operadora` to `/var/www/html` (includes existing `.env`)
- Working directory: `/var/www/html`

### 2. `nginx` (Web Server)
- Image: `nginx:alpine`
- Ports: `8080:80`
- Mount `./operadora` to `/var/www/html`
- Mount custom nginx config
- Depends on: `app`

### 3. `mysql` (Database)
- Image: `mysql:5.7`
- Ports: `3306:3306`
- Environment variables for credentials
- Persistent volume: `mysql_data`
- Healthcheck for readiness

### 4. `redis` (Cache - Optional)
- Image: `redis:alpine`
- Ports: `6379:6379`

### 5. `mailhog` (Email Testing - Optional)
- Image: `mailhog/mailhog`
- Ports: `8025:8025` (Web UI), `1025:1025` (SMTP)

### 6. `node` (Asset Compilation - Optional)
- Image: `node:12-alpine`
- Mount `./operadora` to `/var/www/html`
- Run `npm install && npm run dev`

---

## Acceptance Criteria

- [ ] `docker-compose up -d` starts all services
- [ ] Application accessible at `http://localhost:8080`
- [ ] Existing `operadora/.env` file is used by the containers
- [ ] Database persists data between restarts
- [ ] `php artisan migrate` works from app container
- [ ] `php artisan db:seed` populates test data
- [ ] Assets compile correctly with `npm run dev`
- [ ] Timezone configured to `America/Mexico_City`

---

## Useful Commands

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f app

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear

# Run composer
docker-compose exec app composer install

# Run npm
docker-compose run --rm node npm install
docker-compose run --rm node npm run dev

# Access MySQL CLI
docker-compose exec mysql mysql -u operadora -p operadora_db

# Rebuild containers
docker-compose build --no-cache
```

---

## Notes

- Laravel 5.7 is an older version; PHP 7.4 is the best balance of compatibility and security
- MySQL 5.7 matches the production environment expectations
- The existing `.env` file at `operadora/.env` will be mounted directly - update `DB_HOST`, `REDIS_HOST`, and `MAIL_HOST` values for Docker networking
- The `public_html/` directory is separate from `operadora/public/` - verify symlinks if needed
- Twilio credentials in the existing `.env` should be kept secure and not committed to version control
