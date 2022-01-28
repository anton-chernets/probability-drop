```
composer install
```
- add .env from .env.example with db connection and run commands
```
php artisan migrate
php artisan key:generate
```
- for data set
```
php artisan db:seed --class=DatabaseSeeder
```
- api docs for testing
```
www url ../api/documentation
```