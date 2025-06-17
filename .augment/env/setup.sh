#!/bin/bash
set -e

# Update system packages
sudo apt-get update

# Install PHP 8.1 and required extensions
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get install -y php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml php8.1-curl php8.1-gd php8.1-mbstring php8.1-zip php8.1-bcmath php8.1-intl php8.1-sqlite3 php8.1-dom php8.1-fileinfo

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install Node.js and npm
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Add tools to PATH
echo 'export PATH="/usr/local/bin:$PATH"' >> $HOME/.profile

# Navigate to workspace and install PHP dependencies
cd /mnt/persist/workspace
composer install --no-interaction --prefer-dist

# Install JavaScript dependencies
npm install

# Copy environment file and configure for testing
cp .env.example .env

# Configure .env for testing with SQLite
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_HOST=127.0.0.1/#DB_HOST=127.0.0.1/' .env
sed -i 's/DB_PORT=3306/#DB_PORT=3306/' .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=database\/database.sqlite/' .env
sed -i 's/DB_USERNAME=root/#DB_USERNAME=root/' .env
sed -i 's/DB_PASSWORD=/#DB_PASSWORD=/' .env

# Generate application key
php artisan key:generate

# Create SQLite database for testing
mkdir -p database
touch database/database.sqlite

# Update phpunit.xml to use SQLite for testing
sed -i 's/<!-- <env name="DB_CONNECTION" value="sqlite"\/> -->/<env name="DB_CONNECTION" value="sqlite"\/>/' phpunit.xml
sed -i 's/<!-- <env name="DB_DATABASE" value=":memory:"\/> -->/<env name="DB_DATABASE" value=":memory:"\/>/' phpunit.xml

# Fix UserFactory to include required fields
cat > database/factories/UserFactory.php << 'EOF'
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'agent',
            'genre' => fake()->randomElement(['M', 'F']),
            'hospital' => fake()->company(),
            'numero_matricule' => fake()->unique()->numerify('MAT###'),
            'qualification' => fake()->jobTitle(),
            'date_d_ajout' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
EOF

# Create storage directories and set proper permissions
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app
mkdir -p bootstrap/cache

# Set proper permissions for current user
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R $(whoami):$(whoami) storage
chown -R $(whoami):$(whoami) bootstrap/cache

# Clear and cache configuration
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations to set up database structure
php artisan migrate --force

# Build frontend assets
npm run build