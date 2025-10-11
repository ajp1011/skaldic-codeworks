# Skaldic Codeworks

A modern software development company and portfolio website built with Laravel 12, Vue.js, TypeScript, and Tailwind CSS.

> 🚀 **Open Source Portfolio** - This repository showcases professional web development practices and modern full-stack architecture. Feel free to explore the code, and if you're hiring or need development services, [get in touch](mailto:ajp1011@gmail.com)!

## Tech Stack

- **Backend**: Laravel 12.x with PHP 8.4
- **Frontend**: Vue.js 3 with TypeScript
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **Testing**: PEST 4
- **Database**: MySQL 8.0
- **Containerization**: Docker & Docker Compose

## Quick Start

### Prerequisites
- Docker & Docker Compose
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/skaldic-codeworks.git
   cd skaldic-codeworks
   ```

2. **Copy environment file**
   ```bash
   cp env.example .env
   ```

3. **Start the development environment**
   ```bash
   docker-compose up -d --build
   ```

4. **Generate application key**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Access the application**
   - Website: http://localhost:8000
   - Vite Dev Server: http://localhost:5173
   - Database: localhost:3306

## Development

### Running Tests
```bash
docker-compose exec app php artisan test
```

### Frontend Development
```bash
docker-compose exec node npm run dev
```

### Building for Production
```bash
docker-compose exec node npm run build
```

### Database Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Fresh migration with seeding
docker-compose exec app php artisan migrate:fresh --seed
```

### Code Quality
```bash
# Run Laravel Pint (code formatting)
docker-compose exec app ./vendor/bin/pint

# Run PHPStan (static analysis)
docker-compose exec app ./vendor/bin/phpstan analyse
```

## Project Structure

```
├── app/                    # Laravel application logic
├── resources/              # Views, Vue components, assets
│   ├── js/                # TypeScript/Vue files
│   ├── css/               # Stylesheets
│   └── views/             # Blade templates
├── public/                 # Web-accessible files
├── docker/                 # Docker configuration
├── tests/                  # PEST test files
├── Dockerfile              # Container definition
├── docker-compose.yml      # Service orchestration
└── README.md               # This file
```

## Features

- 🚀 **Modern PHP 8.4** with latest language features
- ⚡ **Vue.js 3** with Composition API and TypeScript
- 🎨 **Tailwind CSS** for utility-first styling
- 🧪 **PEST 4** for elegant testing
- 🐳 **Docker** for consistent development environment
- 📱 **Responsive design** for all devices
- ✨ **Vite HMR** for instant development feedback
- 🔒 **Laravel best practices** for security and performance

## About

This project serves as both the company website for Skaldic Codeworks and a demonstration of modern full-stack development practices. The codebase showcases:

- Clean architecture and separation of concerns
- Type-safe frontend development with TypeScript
- Comprehensive testing strategies
- Docker-based development workflow
- Modern CI/CD readiness

## Contact

Interested in working together or have questions about the project?

- **Email**: ajp1011@gmail.com
- **Company**: Skaldic Codeworks, LLC

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

⭐ **If you find this project interesting or useful, please consider giving it a star!**
