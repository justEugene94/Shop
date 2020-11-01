# Installation
* #### Clone Project

```
cd /var/www
sudo mkdir shop
sudo chown {{YOUR_USER}}:{{YOUR_USER}} shop

git clone git@github.com:justEugene94/Shop.git shop
```

```bash
cp .env.example .env
```

* #### Open and configure `.env` file

* #### Build Docker

```bash
sudo service nginx stop
sudo service mysql stop

cd docker/
docker-compose up --build
```

* #### Install composer and seed the database

```bash
docker-compose exec workspace bash

composer install

php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```
