#!/bin/bash

# Hostinger Deployment Script
# This script will be used for initial setup on Hostinger

echo "🚀 Setting up CMS Project on Hostinger..."

# Navigate to public_html
cd public_html

# Clone the repository
echo "📥 Cloning repository..."
git clone https://github.com/ammamustufa12/cms_system_project.git

# Navigate to project directory
cd cms_system_project

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Setup environment
echo "⚙️ Setting up environment..."
cp .env.example .env

# Generate application key
php artisan key:generate

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Clear caches
echo "🧹 Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Optimize application
php artisan optimize

echo "✅ Setup completed!"
echo "📝 Next steps:"
echo "1. Configure .env file with your database details"
echo "2. Run: php artisan migrate"
echo "3. Set up your domain to point to public_html/cms_system_project/public"
echo "4. Push to GitHub to trigger automatic deployment!"
