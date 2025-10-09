# Docker Development Environment

This project uses Docker for local development. The setup includes:

- **Laravel** (PHP 8.2) - Backend framework
- **Vue.js** with **TypeScript** - Frontend framework
- **Vite** - Frontend build tool
- **Tailwind CSS** - CSS framework
- **MySQL 8.0** - Database
- **Nginx** - Web server

## Quick Start

1. **Copy environment file:**
   ```bash
   cp env.example .env
   ```

2. **Start the development environment:**
   ```bash
   docker-compose up -d
   ```

3. **Install Laravel dependencies:**
   ```bash
   docker-compose exec app composer install
   ```

4. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. **Run database migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Install frontend dependencies:**
   ```bash
   docker-compose exec node npm install
   ```

7. **Build frontend assets:**
   ```bash
   docker-compose exec node npm run build
   ```

## Access Points

- **Website:** http://localhost:8000
- **Vite Dev Server:** http://localhost:5173
- **Database:** localhost:3306
  - Username: `laravel`
  - Password: `password`
  - Database: `skaldic_codeworks`

## Development Commands

### Laravel Commands
```bash
# Run artisan commands
docker-compose exec app php artisan [command]

# Run migrations
docker-compose exec app php artisan migrate

# Clear cache
docker-compose exec app php artisan cache:clear
```

### Frontend Commands
```bash
# Install dependencies
docker-compose exec node npm install

# Development build with hot reload
docker-compose exec node npm run dev

# Production build
docker-compose exec node npm run build

# Watch for changes
docker-compose exec node npm run watch
```

## Services

- **app**: Laravel application (PHP-FPM)
- **nginx**: Web server
- **db**: MySQL database
- **node**: Node.js for frontend development

## Stopping the Environment

```bash
docker-compose down
```

To also remove volumes (database data):
```bash
docker-compose down -v
```
