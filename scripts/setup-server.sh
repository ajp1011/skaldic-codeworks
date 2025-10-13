#!/bin/bash
# Initial server setup script for Ubuntu 24.04

set -e

echo "========================================"
echo "Skaldic Codeworks - Server Setup"
echo "========================================"

# Update system
echo "Updating system packages..."
sudo apt-get update
sudo apt-get upgrade -y

# Install essential packages
echo "Installing essential packages..."
sudo apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg \
    lsb-release \
    git \
    ufw \
    fail2ban \
    unattended-upgrades \
    awscli \
    gpg

# Install Docker
echo "Installing Docker..."
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
rm get-docker.sh

# Install Docker Compose
echo "Installing Docker Compose..."
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Create deploy user
echo "Creating deploy user..."
if ! id -u deploy > /dev/null 2>&1; then
    sudo useradd -m -s /bin/bash deploy
    sudo usermod -aG docker deploy
    sudo usermod -aG sudo deploy
    echo "deploy ALL=(ALL) NOPASSWD: /usr/bin/docker, /usr/bin/docker-compose, /usr/local/bin/docker-compose" | sudo tee /etc/sudoers.d/deploy
fi

# Configure UFW firewall
echo "Configuring firewall..."
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw --force enable

# Configure fail2ban
echo "Configuring fail2ban..."
sudo systemctl enable fail2ban
sudo systemctl start fail2ban

# Enable automatic security updates
echo "Enabling automatic security updates..."
echo 'APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Unattended-Upgrade "1";
APT::Periodic::AutocleanInterval "7";
Unattended-Upgrade::Automatic-Reboot "false";' | sudo tee /etc/apt/apt.conf.d/20auto-upgrades

# Create application directory
echo "Creating application directory..."
sudo mkdir -p /var/www
sudo chown -R deploy:deploy /var/www

# Configure log rotation
echo "Configuring log rotation..."
cat << 'EOF' | sudo tee /etc/logrotate.d/skaldic-codeworks
/var/www/skaldic-codeworks/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0664 www-data www-data
    sharedscripts
}
EOF

