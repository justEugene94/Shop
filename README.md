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

```bash
composer install

php artisan key:generate

php artisan migrate
php artisan db:seed
```
