# Technology Stack

## Backend Framework
- **Laravel**: 5.7.*
- **PHP**: ^7.1.3 (minimum requirement)

## Database
- **MySQL** (configured via .env)
- **Eloquent ORM** for database operations

## Frontend
- **Blade Templates**: Laravel's templating engine
- **Bootstrap**: CSS framework (via views)
- **jQuery**: JavaScript interactions
- **Chart.js**: Sales analytics visualizations

## Key Packages (composer.json)

### Production Dependencies
```json
{
    "php": "^7.1.3",
    "barryvdh/laravel-dompdf": "^0.8.4",  // PDF generation
    "fideloper/proxy": "^4.0",             // Trusted proxies
    "laravel/framework": "5.7.*",          // Core framework
    "laravel/tinker": "^1.0",              // REPL debugging
    "twilio/sdk": "^5.32"                  // SMS notifications
}
```

### Development Dependencies
```json
{
    "beyondcode/laravel-dump-server": "^1.0",
    "filp/whoops": "^2.0",                 // Error handling
    "fzaninotto/faker": "^1.4",            // Test data generation
    "mockery/mockery": "^1.0",             // Testing mocks
    "nunomaduro/collision": "^2.0",        // CLI error handling
    "phpunit/phpunit": "^7.0"              // Testing framework
}
```

## Third-Party Integrations
- **Twilio**: SMS notifications for reservation confirmations
- **DomPDF**: PDF generation for reports and tickets

## Frontend Assets (webpack.mix.js)
- Laravel Mix for asset compilation
- SASS/CSS compilation
- JavaScript bundling

## PHP Extensions Required
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath

## Environment Configuration
Key `.env` variables:
```
APP_NAME=Laravel
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=operadora_db
DB_USERNAME=root
DB_PASSWORD=

TWILIO_ACCOUNT_SID=your_sid
TWILIO_AUTH_TOKEN=your_token

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

## Docker Development Environment

### Container Stack
- **PHP**: 7.4-fpm with required extensions
- **Composer**: 1.x (required - Laravel 5.7 incompatible with Composer 2.x)
- **MariaDB**: 10.6 (MySQL-compatible, ARM64/Apple Silicon support)
- **Nginx**: Alpine (serves from `public_html/`)
- **Redis**: Alpine (optional cache)
- **Mailpit**: Email testing (ARM64-compatible replacement for Mailhog)
- **Node**: 12-alpine (asset compilation)

### Docker Commands
```bash
# Start all services
docker-compose up -d

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# Run composer
docker-compose exec app composer install

# Run npm (asset compilation)
docker-compose run --rm node npm install
docker-compose run --rm node npm run dev

# Access MySQL CLI
docker-compose exec mysql mysql -u operadora -p operadora_db
```

### Access Points
- Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (auto-login, 512MB upload limit for DB restores)
- Mailpit UI: http://localhost:8025
- MySQL/MariaDB: localhost:3306

### Compatibility Notes
- **Composer 1.x required**: Laravel 5.7's PackageManifest is incompatible with Composer 2.x's `installed.json` format
- **MariaDB instead of MySQL**: MySQL 5.7 has no ARM64 image; MariaDB 10.6 is fully compatible
- **Mailpit instead of Mailhog**: Mailhog has no ARM64 image

## Native Development Commands
```bash
# Database migration
php artisan migrate

# Seed database with test data
php artisan db:seed

# Fresh migration with seeds
php artisan migrate:fresh --seed

# Individual seeder
php artisan db:seed --class=UsersTableSeeder

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```
