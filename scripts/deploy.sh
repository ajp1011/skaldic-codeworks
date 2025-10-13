#!/bin/bash
# Deployment script for Skaldic Codeworks production

set -e

echo "========================================"
echo "Starting deployment..."
echo "========================================"

# Change to application directory
cd /var/www/skaldic-codeworks

# Pull latest code from GitHub
echo "Pulling latest code..."
git pull origin main

# Fetch secrets from AWS Parameter Store
echo "Fetching secrets from AWS Parameter Store..."

# Get region from environment or EC2 metadata
if [ -z "$AWS_REGION" ]; then
    AWS_REGION=$(curl -s http://169.254.169.254/latest/meta-data/placement/region 2>/dev/null || echo "us-east-1")
fi

# Parameter Store path prefix
PARAM_PREFIX="${PARAM_PREFIX:-/skaldic-codeworks/production}"

# Fetch parameters
DB_PASSWORD=$(aws ssm get-parameter --name "$PARAM_PREFIX/db-password" --with-decryption --query 'Parameter.Value' --output text --region $AWS_REGION)
DB_ROOT_PASSWORD=$(aws ssm get-parameter --name "$PARAM_PREFIX/db-root-password" --with-decryption --query 'Parameter.Value' --output text --region $AWS_REGION)
APP_KEY=$(aws ssm get-parameter --name "$PARAM_PREFIX/app-key" --with-decryption --query 'Parameter.Value' --output text --region $AWS_REGION)

# Create .env file
cat > .env << EOF
APP_NAME="SkaldicCodeworks"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=https://skaldiccodeworks.dev

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=skaldic_codeworks
DB_USERNAME=laravel
DB_PASSWORD=${DB_PASSWORD}
DB_ROOT_PASSWORD=${DB_ROOT_PASSWORD}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@skaldiccodeworks.dev"
MAIL_FROM_NAME="\${APP_NAME}"
EOF

chmod 600 .env
echo "Secrets fetched and .env created"

# Pull latest Docker images
echo "Pulling Docker images..."
docker compose -f docker-compose.prod.yml pull

# Stop existing containers
echo "Stopping existing containers..."
docker compose -f docker-compose.prod.yml down

# Build and start new containers
echo "Starting new containers..."
docker compose -f docker-compose.prod.yml up -d --build

# Wait for database to be ready
echo "Waiting for database..."
sleep 10

# Run database migrations
echo "Running migrations..."
docker compose -f docker-compose.prod.yml exec -T app php artisan migrate --force

# Clear and cache Laravel configuration
echo "Optimizing Laravel..."
docker compose -f docker-compose.prod.yml exec -T app php artisan config:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan route:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan view:cache

# Set proper permissions
echo "Setting permissions..."
docker compose -f docker-compose.prod.yml exec -T app chown -R www-data:www-data /var/www/storage
docker compose -f docker-compose.prod.yml exec -T app chmod -R 775 /var/www/storage

# Health check
echo "Running health check..."
sleep 5
if curl -f http://localhost > /dev/null 2>&1; then
    echo "Application is responding"
else
    echo "Warning: Application may not be responding properly"
fi

echo "========================================"
echo "Deployment completed successfully!"
echo "========================================"

