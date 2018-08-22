# rogue-two
 
git clone git@github.com:nplek/rogue-two.git
 
composer install

cp .env.example .env

###configure .env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DB>
DB_USERNAME=<USER>
DB_PASSWORD=<PASSWORD>
###configure .env

php artisan key:generate

php artisan migrate
or
php artisan migrate --seed

php artisan passport:keys

php artisan passport:client --personal

