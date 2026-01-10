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

## Development Commands
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
