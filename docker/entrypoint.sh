#!/bin/bash
set -e
cd /var/www

if [ ! -f artisan ]; then
  echo "Creating Laravel project..."
  composer create-project laravel/laravel /tmp/laravel --prefer-dist --no-interaction
  shopt -s dotglob
  mv /tmp/laravel/* /var/www/
  mv /tmp/laravel/.[!.]* /var/www/ 2>/dev/null || true
  rm -rf /tmp/laravel
  echo "Laravel project created."

  # Configure .env for Docker MySQL
  if [ -f .env.example ] && [ ! -f .env ]; then
    cp .env.example .env
    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel/' .env
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=laravel/' .env
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' .env
    php artisan key:generate --no-interaction
    echo ".env configured for Docker."
  fi
fi

exec php artisan serve --host=0.0.0.0 --port=8000
