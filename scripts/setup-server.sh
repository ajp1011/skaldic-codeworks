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
    unzip \
    gpg

# Install AWS CLI v2
echo "Installing AWS CLI v2..."
if command -v aws &> /dev/null; then
    echo "✓ AWS CLI already installed ($(aws --version))"
else
    TEMP_DIR=$(mktemp -d)
    cd "$TEMP_DIR"
    if curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"; then
        unzip -q awscliv2.zip
        sudo ./aws/install
        cd -
        rm -rf "$TEMP_DIR"
        echo "✓ AWS CLI installed successfully"
    else
        echo "✗ Failed to download AWS CLI"
        cd -
        rm -rf "$TEMP_DIR"
        exit 1
    fi
fi

# Install Docker
echo "Installing Docker..."
if command -v docker &> /dev/null; then
    echo "✓ Docker already installed ($(docker --version))"
else
    if curl -fsSL https://get.docker.com -o get-docker.sh; then
        if sudo sh get-docker.sh; then
            rm get-docker.sh
            echo "✓ Docker installed successfully"
        else
            echo "✗ Docker installation failed"
            rm get-docker.sh
            exit 1
        fi
    else
        echo "✗ Failed to download Docker install script"
        exit 1
    fi
fi

# Start and enable Docker
echo "Starting Docker service..."
sudo systemctl start docker
sudo systemctl enable docker

# Verify Docker is running
if ! sudo systemctl is-active --quiet docker; then
    echo "✗ Docker service failed to start"
    exit 1
fi
echo "✓ Docker service is running"

# Install Docker Compose
echo "Installing Docker Compose..."
if sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose; then
    sudo chmod +x /usr/local/bin/docker-compose
    echo "✓ Docker Compose installed successfully"
else
    echo "✗ Failed to install Docker Compose"
    exit 1
fi

# Verify installations
echo "Verifying installations..."
docker --version || { echo "✗ Docker verification failed"; exit 1; }
docker-compose --version || docker compose version || { echo "✗ Docker Compose verification failed"; exit 1; }
aws --version || { echo "✗ AWS CLI verification failed"; exit 1; }
echo "✓ All installations verified"

# Create deploy user
echo "Creating deploy user..."
if ! id -u deploy > /dev/null 2>&1; then
    sudo useradd -m -s /bin/bash deploy
    sudo usermod -aG docker deploy
    sudo usermod -aG sudo deploy
    echo "deploy ALL=(ALL) NOPASSWD: /usr/bin/docker, /usr/bin/docker-compose, /usr/local/bin/docker-compose" | sudo tee /etc/sudoers.d/deploy
    echo "✓ Deploy user created"
else
    echo "✓ Deploy user already exists"
fi

# Add ubuntu user to docker group
echo "Adding ubuntu user to docker group..."
sudo usermod -aG docker ubuntu
echo "✓ Ubuntu user added to docker group"

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

# Create swap space (critical for t3.micro with 1GB RAM)
echo "Setting up swap space..."
if [ ! -f /swapfile ]; then
    sudo fallocate -l 2G /swapfile
    sudo chmod 600 /swapfile
    sudo mkswap /swapfile
    sudo swapon /swapfile
    echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab
    echo "✓ 2GB swap space created"
else
    echo "✓ Swap space already configured"
fi

# Create application directory
echo "Creating application directory..."
sudo mkdir -p /var/www
sudo chown -R ubuntu:ubuntu /var/www
echo "✓ Application directory created with correct ownership"

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

