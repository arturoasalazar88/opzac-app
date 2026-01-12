# Story 001: Docker Compose Setup for Operadora Zacatecas

**Status:** Complete
**Completion Date:** 2025-01-11

---

## Implementation Summary

✅ Docker dev environment with PHP-FPM, Nginx, MariaDB, Redis, phpMyAdmin
- Docker Compose multi-container setup with ARM64-compatible images
- Verified working on Apple Silicon (M1), all services healthy
- PHP 7.4-FPM, MariaDB 10.6, Nginx, Redis, Composer 1.x (Laravel 5.7 compat)

---

## Overview
Create a Docker Compose configuration to run the Operadora Zacatecas Laravel application locally for development purposes.

---

## Technical Requirements

### PHP Application Container
- **PHP Version**: 7.1.3+ (use `php:7.4-fpm` for stability with Laravel 5.7)
- **Composer Version**: 1.x (required - Laravel 5.7 is incompatible with Composer 2.x `installed.json` format)
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
- Configure to serve from `public_html/` (Laravel public folder moved outside app root)
- Handle PHP-FPM upstream

### Database Container
- **MariaDB 10.6** (MySQL-compatible, ARM64/Apple Silicon support)
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

# Change MAIL_HOST if using Mailpit
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### Volume Mount Strategy

Mount the entire project root to preserve relative paths between `operadora/` and `public_html/`:

```yaml
volumes:
  - .:/var/www/html
```

This will create the following structure in the container:
```
/var/www/html/
├── operadora/        # Laravel app with .env
└── public_html/      # Public folder (Nginx serves from here)
```

The `public_html/index.php` uses `../operadora/` paths which work correctly with this mount.

---

## Directory Structure to Create

```
opzac-app/
├── docker/
│   ├── nginx/
│   │   └── default.conf       # Nginx site configuration
│   ├── php/
│   │   └── Dockerfile         # PHP-FPM with extensions
│   └── mysql/
│       └── init.sql           # Optional: Initial database setup
├── docker-compose.yml         # Main compose file
├── operadora/                 # Laravel app (without public/)
│   └── .env                   # EXISTING - Mount this file into containers
└── public_html/               # Laravel public folder (moved outside app root)
    └── index.php              # Entry point (uses ../operadora/ paths)
```

**Important:** The `public_html/` directory is the Laravel public folder, moved outside the `operadora/` directory for hosting compatibility. The `index.php` uses relative paths like `../operadora/vendor/autoload.php` to bootstrap the application.

---

## Services to Include

### 1. `app` (PHP-FPM)
- Build from custom Dockerfile
- Install Composer
- Install required PHP extensions
- Mount project root `.` to `/var/www/html` (preserves relative paths)
- Working directory: `/var/www/html/operadora`

### 2. `nginx` (Web Server)
- Image: `nginx:alpine`
- Ports: `8080:80`
- Mount project root `.` to `/var/www/html`
- Serve from `/var/www/html/public_html`
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

### 5. `mailpit` (Email Testing - Optional)
- Image: `axllent/mailpit` (ARM64-compatible replacement for Mailhog)
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
- **Composer 1.x** is required - Laravel 5.7's PackageManifest is incompatible with Composer 2.x's `installed.json` format
- **MariaDB 10.6** is used instead of MySQL 5.7 for ARM64/Apple Silicon compatibility (fully MySQL-compatible)
- **Mailpit** is used instead of Mailhog for ARM64/Apple Silicon compatibility
- The existing `.env` file at `operadora/.env` will be mounted directly - update `DB_HOST`, `REDIS_HOST`, and `MAIL_HOST` values for Docker networking
- The `public_html/` directory IS the Laravel public folder (moved outside `operadora/` for hosting). The `index.php` uses `../operadora/` relative paths to bootstrap the app
- The entire project root is mounted to `/var/www/html` to preserve these relative paths
- Twilio credentials in the existing `.env` should be kept secure and not committed to version control
- Use `operadora/.env.docker.example` as a template for Docker-specific environment settings
