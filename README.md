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

cp .env.example .env

docker-compose up --build
```

* #### Install composer and seed the database

```bash
docker-compose exec workspace bash

composer install
npm install

php artisan key:generate

npm run dev

php artisan migrate
php artisan db:seed --class='DeveloperSeeder'

php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

* #### Start Watcher

```bash
npm run watch
```
