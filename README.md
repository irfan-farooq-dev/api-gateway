
## API Gateway

A lightweight **API Gateway** built with Laravel that routes incoming API requests to the appropriate microservice (e.g., **auth-service**, **profile-service**). It centralizes authentication (JWT verification), request proxying, and simple orchestration between services.

---

## 🚀 Features
- Routes and forwards API requests to downstream microservices (Auth, Profile, etc.)
- JWT validation middleware (see `app/Http/Middleware/JwtMiddleware.php`)
- Centralized entry point for API documentation and observability
- Lightweight, framework-based implementation using Laravel

---

## 📂 Project Setup

### Requirements
- PHP >= 8.1
- Composer
- (Optional) MySQL if you enable persistence for logs
- Laravel Sail / Herd / Valet or the PHP built-in server

### Installation
```bash
# Clone the repository
git clone https://github.com/irfan-farooq-dev/api-gateway.git

cd api-gateway

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

### Configuration
Edit `.env` and set the microservice endpoints used by the gateway, for example:
```
AUTH_SERVICE_URL=http://localhost:8001
PROFILE_SERVICE_URL=http://localhost:8002
```
Make sure `config/services.php` references these environment variables (e.g., `'auth' => env('AUTH_SERVICE_URL')`).

### Running locally
```bash
# Start the application
php artisan serve --port=8000

# Visit API documentation
http://localhost:8000/api/documentation
```

### Notes
- The gateway uses `JwtMiddleware` to validate JWTs by fetching the public key from the auth service.
- API documentation JSON is available under `storage/api-docs/api-docs.json`.

---

## Contributing
See `CONTRIBUTING.md` or open an issue to discuss changes.

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

