# Skaldic Codeworks

A modern software development company and portfolio website built with Laravel 12, Vue.js, TypeScript, and Tailwind CSS.

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
   git clone <repository-url>
   cd skaldic-codeworks
   ```

2. **Start the development environment**
   ```bash
   docker-compose up -d --build
   ```

3. **Access the application**
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

### Database Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed
```

## Project Structure

```
├── app/                    # Laravel application logic
├── resources/              # Views, Vue components, assets
├── public/                 # Web-accessible files
├── docker/                 # Docker configuration
├── tests/                  # PEST test files
├── Dockerfile              # Container definition
├── docker-compose.yml      # Service orchestration
└── README.md               # This file
```

## Features

- 🚀 **Modern PHP 8.4** with latest language features
- ⚡ **Vue.js 3** with Composition API
- 🎨 **Tailwind CSS** for utility-first styling
- 🧪 **PEST 4** for elegant testing
- 🐳 **Docker** for consistent development environment
- 📱 **Responsive design** for all devices

## License

This project is proprietary and confidential software. All rights reserved.

Copyright (c) 2025 Skaldic Codeworks, LLC. 

Unauthorized copying, modification, distribution, or use of this software is strictly prohibited. 
See the [LICENSE](LICENSE) file for details.