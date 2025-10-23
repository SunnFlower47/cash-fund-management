# 🚀 Deployment Guide

## Overview

Panduan lengkap untuk deployment Cash Management System ke production environment dengan konfigurasi yang optimal untuk performa, keamanan, dan skalabilitas.

## 📋 Prerequisites

### System Requirements
- **OS**: Ubuntu 20.04 LTS atau CentOS 8+
- **RAM**: Minimum 2GB, Recommended 4GB+
- **Storage**: Minimum 20GB, Recommended 50GB+
- **CPU**: Minimum 2 cores, Recommended 4 cores+

### Software Requirements
- **PHP**: 8.1 atau lebih tinggi
- **MySQL**: 8.0 atau lebih tinggi
- **Nginx**: 1.18+ atau Apache 2.4+
- **Composer**: Latest version
- **Node.js**: 16+ dan NPM
- **SSL Certificate**: Let's Encrypt atau commercial

## 🛠️ Installation Steps

### 1. Server Setup

#### Update System
```bash
sudo apt update && sudo apt upgrade -y
```

#### Install Required Packages
```bash
sudo apt install -y software-properties-common curl wget git unzip
```

### 2. PHP Installation

#### Add PHP Repository
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
```

#### Install PHP and Extensions
```bash
sudo apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring \
    php8.1-curl php8.1-zip php8.1-bcmath php8.1-gd php8.1-intl php8.1-cli
```

#### Configure PHP
```bash
sudo nano /etc/php/8.1/fpm/php.ini
```

**Key Settings**:
```ini
memory_limit = 256M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
max_input_vars = 3000
date.timezone = Asia/Jakarta
```

### 3. MySQL Installation

#### Install MySQL
```bash
sudo apt install -y mysql-server mysql-client
```

#### Secure MySQL
```bash
sudo mysql_secure_installation
```

#### Create Database and User
```sql
CREATE DATABASE cash_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'cash_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON cash_management.* TO 'cash_user'@'localhost';
FLUSH PRIVILEGES;
```

### 4. Nginx Installation

#### Install Nginx
```bash
sudo apt install -y nginx
```

#### Configure Nginx
```bash
sudo nano /etc/nginx/sites-available/cash-management
```

**Nginx Configuration**:
```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/cash-management/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied expired no-cache no-store private must-revalidate auth;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Static files caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Security - deny access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ /(storage|bootstrap/cache) {
        deny all;
    }
}
```

#### Enable Site
```bash
sudo ln -s /etc/nginx/sites-available/cash-management /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 5. Application Deployment

#### Create Application Directory
```bash
sudo mkdir -p /var/www/cash-management
sudo chown -R www-data:www-data /var/www/cash-management
```

#### Clone Repository
```bash
cd /var/www/cash-management
sudo -u www-data git clone https://github.com/your-repo/cash-management.git .
```

#### Install Dependencies
```bash
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run build
```

#### Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/cash-management
sudo chmod -R 755 /var/www/cash-management
sudo chmod -R 775 /var/www/cash-management/storage
sudo chmod -R 775 /var/www/cash-management/bootstrap/cache
```

### 6. Environment Configuration

#### Create Environment File
```bash
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

**Production .env Configuration**:
```env
APP_NAME="Cash Management System"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cash_management
DB_USERNAME=cash_user
DB_PASSWORD=strong_password_here

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=redis
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

#### Generate Application Key
```bash
sudo -u www-data php artisan key:generate
```

### 7. Database Setup

#### Run Migrations
```bash
sudo -u www-data php artisan migrate --force
```

#### Seed Database
```bash
sudo -u www-data php artisan db:seed --force
```

#### Add Production Permissions
```bash
sudo -u www-data php artisan db:seed --class=ProductionPermissionsSeeder --force
```

### 8. SSL Certificate

#### Install Certbot
```bash
sudo apt install -y certbot python3-certbot-nginx
```

#### Obtain SSL Certificate
```bash
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

#### Auto-renewal Setup
```bash
sudo crontab -e
# Add this line:
0 12 * * * /usr/bin/certbot renew --quiet
```

### 9. Redis Installation (Optional)

#### Install Redis
```bash
sudo apt install -y redis-server
```

#### Configure Redis
```bash
sudo nano /etc/redis/redis.conf
```

**Key Settings**:
```
maxmemory 256mb
maxmemory-policy allkeys-lru
```

#### Start Redis
```bash
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### 10. Application Optimization

#### Cache Configuration
```bash
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache
```

#### Queue Configuration (Optional)
```bash
sudo -u www-data php artisan queue:work --daemon
```

## 🔧 Production Configuration

### 1. PHP-FPM Optimization

#### Configure PHP-FPM Pool
```bash
sudo nano /etc/php/8.1/fpm/pool.d/www.conf
```

**Key Settings**:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 1000
```

### 2. MySQL Optimization

#### Configure MySQL
```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

**Key Settings**:
```ini
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT
max_connections = 200
query_cache_size = 64M
query_cache_type = 1
```

### 3. Nginx Optimization

#### Configure Nginx
```bash
sudo nano /etc/nginx/nginx.conf
```

**Key Settings**:
```nginx
worker_processes auto;
worker_connections 1024;
keepalive_timeout 65;
client_max_body_size 10M;
```

### 4. System Monitoring

#### Install Monitoring Tools
```bash
sudo apt install -y htop iotop nethogs
```

#### Create Monitoring Script
```bash
sudo nano /usr/local/bin/monitor-cash-app.sh
```

**Monitoring Script**:
```bash
#!/bin/bash
# Monitor Cash Management System

echo "=== Cash Management System Status ==="
echo "Date: $(date)"
echo ""

# Check services
echo "=== Services Status ==="
systemctl status nginx --no-pager -l
systemctl status php8.1-fpm --no-pager -l
systemctl status mysql --no-pager -l

echo ""
echo "=== Disk Usage ==="
df -h

echo ""
echo "=== Memory Usage ==="
free -h

echo ""
echo "=== Application Status ==="
cd /var/www/cash-management
sudo -u www-data php artisan about
```

#### Make Script Executable
```bash
sudo chmod +x /usr/local/bin/monitor-cash-app.sh
```

### 5. Backup Configuration

#### Create Backup Script
```bash
sudo nano /usr/local/bin/backup-cash-app.sh
```

**Backup Script**:
```bash
#!/bin/bash
# Backup Cash Management System

BACKUP_DIR="/var/backups/cash-management"
DATE=$(date +%Y%m%d_%H%M%S)
APP_DIR="/var/www/cash-management"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u cash_user -p cash_management > $BACKUP_DIR/database_$DATE.sql

# Application backup
tar -czf $BACKUP_DIR/application_$DATE.tar.gz -C $APP_DIR .

# File storage backup
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz -C $APP_DIR storage/

# Cleanup old backups (keep 7 days)
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

#### Schedule Backup
```bash
sudo crontab -e
# Add this line for daily backup at 2 AM:
0 2 * * * /usr/local/bin/backup-cash-app.sh
```

## 🔒 Security Configuration

### 1. Firewall Setup

#### Configure UFW
```bash
sudo ufw enable
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw deny 3306/tcp
```

### 2. File Permissions

#### Set Secure Permissions
```bash
sudo chown -R www-data:www-data /var/www/cash-management
sudo chmod -R 755 /var/www/cash-management
sudo chmod -R 775 /var/www/cash-management/storage
sudo chmod -R 775 /var/www/cash-management/bootstrap/cache
sudo chmod 600 /var/www/cash-management/.env
```

### 3. SSL Security

#### Configure SSL
```bash
sudo nano /etc/nginx/sites-available/cash-management
```

**SSL Configuration**:
```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    
    # SSL Security
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    # Rest of configuration...
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}
```

## 📊 Performance Monitoring

### 1. Application Monitoring

#### Install New Relic (Optional)
```bash
# Add New Relic repository
wget -O - https://download.newrelic.com/548C16BF.gpg | sudo apt-key add -
echo "deb http://apt.newrelic.com/debian/ newrelic non-free" | sudo tee /etc/apt/sources.list.d/newrelic.list

# Install New Relic
sudo apt update
sudo apt install -y newrelic-php5
```

### 2. Log Monitoring

#### Configure Log Rotation
```bash
sudo nano /etc/logrotate.d/cash-management
```

**Log Rotation Configuration**:
```
/var/www/cash-management/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 644 www-data www-data
    postrotate
        /bin/kill -USR1 `cat /var/run/php/php8.1-fpm.pid 2> /dev/null` 2> /dev/null || true
    endscript
}
```

### 3. Database Monitoring

#### Create Database Monitoring Script
```bash
sudo nano /usr/local/bin/monitor-db.sh
```

**Database Monitoring**:
```bash
#!/bin/bash
# Monitor MySQL performance

echo "=== MySQL Status ==="
mysql -u cash_user -p -e "SHOW PROCESSLIST;"

echo ""
echo "=== Database Size ==="
mysql -u cash_user -p -e "SELECT table_schema AS 'Database', ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' FROM information_schema.tables WHERE table_schema = 'cash_management' GROUP BY table_schema;"

echo ""
echo "=== Slow Queries ==="
mysql -u cash_user -p -e "SELECT * FROM mysql.slow_log ORDER BY start_time DESC LIMIT 10;"
```

## 🚀 Deployment Automation

### 1. Deployment Script

#### Create Deployment Script
```bash
sudo nano /usr/local/bin/deploy-cash-app.sh
```

**Deployment Script**:
```bash
#!/bin/bash
# Deploy Cash Management System

APP_DIR="/var/www/cash-management"
BACKUP_DIR="/var/backups/cash-management"
DATE=$(date +%Y%m%d_%H%M%S)

echo "Starting deployment..."

# Backup current version
echo "Creating backup..."
tar -czf $BACKUP_DIR/pre_deploy_$DATE.tar.gz -C $APP_DIR .

# Pull latest changes
echo "Pulling latest changes..."
cd $APP_DIR
sudo -u www-data git pull origin main

# Install dependencies
echo "Installing dependencies..."
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run build

# Run migrations
echo "Running migrations..."
sudo -u www-data php artisan migrate --force

# Clear caches
echo "Clearing caches..."
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Set permissions
echo "Setting permissions..."
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

echo "Deployment completed!"
```

### 2. CI/CD Pipeline

#### GitHub Actions Workflow
```yaml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Deploy to server
      uses: appleboy/ssh-action@v0.1.5
      with:
        host: ${{ secrets.HOST }}
        username: ${{ secrets.USERNAME }}
        key: ${{ secrets.SSH_KEY }}
        script: |
          cd /var/www/cash-management
          sudo -u www-data git pull origin main
          sudo -u www-data composer install --optimize-autoloader --no-dev
          sudo -u www-data npm install
          sudo -u www-data npm run build
          sudo -u www-data php artisan migrate --force
          sudo -u www-data php artisan config:cache
          sudo -u www-data php artisan route:cache
          sudo -u www-data php artisan view:cache
```

## 🆘 Troubleshooting

### Common Issues

#### 1. Permission Issues
```bash
# Fix file permissions
sudo chown -R www-data:www-data /var/www/cash-management
sudo chmod -R 755 /var/www/cash-management
sudo chmod -R 775 /var/www/cash-management/storage
sudo chmod -R 775 /var/www/cash-management/bootstrap/cache
```

#### 2. Database Connection Issues
```bash
# Check MySQL status
sudo systemctl status mysql

# Test database connection
mysql -u cash_user -p -e "SELECT 1;"
```

#### 3. Nginx Configuration Issues
```bash
# Test Nginx configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

#### 4. PHP-FPM Issues
```bash
# Check PHP-FPM status
sudo systemctl status php8.1-fpm

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

### Log Files

#### Application Logs
```bash
tail -f /var/www/cash-management/storage/logs/laravel.log
```

#### Nginx Logs
```bash
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log
```

#### PHP-FPM Logs
```bash
tail -f /var/log/php8.1-fpm.log
```

## 📞 Support

### Monitoring Commands
```bash
# Check application status
sudo -u www-data php artisan about

# Check queue status
sudo -u www-data php artisan queue:work --once

# Check cache status
sudo -u www-data php artisan cache:clear
```

### Emergency Procedures
```bash
# Emergency maintenance mode
sudo -u www-data php artisan down

# Disable maintenance mode
sudo -u www-data php artisan up

# Clear all caches
sudo -u www-data php artisan optimize:clear
```

---

**Deployment Guide** - Complete production deployment guide for Cash Management System. 🚀✨
