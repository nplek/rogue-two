# rogue-two
 
git clone git@github.com:nplek/rogue-two.git
 
composer install

cp .env.example .env

php artisan key:generate

#configure db

php artisan migrate
or
php artisan migrate --seed

php artisan passport:keys

php artisan passport:client --personal

