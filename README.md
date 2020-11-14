# Carpenter Backend

## Steps To Follow

* Pull repository to your local
* Install dependencies by running `composer install`
* Copy .env.example to .env and set up the database credentials appropriate to your environment
* Run `php artisan migrate` on repo directory
* Run `php artisan serve`.
* Make a get request to `http://127.0.0.1:8000/api/import` so the csv files can be imported to DB
* Enjoy :) 
