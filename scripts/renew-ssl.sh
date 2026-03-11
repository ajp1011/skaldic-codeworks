#!/bin/bash
# Renew Let's Encrypt certificates and reload Nginx.
# Intended for root crontab (e.g. twice daily).

set -e

WEBROOT="/var/www/certbot"
NGINX_CONTAINER="skaldic-codeworks-nginx-prod"

certbot renew --webroot -w "$WEBROOT" --quiet
docker exec "$NGINX_CONTAINER" nginx -s reload
