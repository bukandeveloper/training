# About Laravel adminLTE Starter Kit

Laravel-AdminLTE-Starter-Kit is a clean laravel project with only base functions. 

I have added more functions so the base functions in starter kit are: 

- admin CRUD
- news CRUD
- admin_login_history

## Installing

We need composer, php artisan CLI installed well.

* run composer install
```
composer install
```
* Create database
* Create .env (copy-paste-rename .env.example), set/connect the database
* Generate new laravel key
```
php artisan key:generate
```
* Run migration and seed
```
php artisan migrate:fresh --seed
```
* Serve laravel, your new development will run on http://127.0.0.1:8000
```
php artisan serve
```

## Working on Migration

Migration is the solution for developing system design,
in development state, sometimes the database structure may changed
and other developer team member need to know, what entities have been changed
so other member can adjust the Model / Controller / View depends on the database.

You don't need export and re-import the database if there are something changed in the database structure.

You can find migration directory in database/migrations

Best practice to generate migration is
```
php artisan make:model Home -m
php artisan make:migration create_messages_table --create=messages
```
When you create new Model it's better to create the migration directly

## Working on seeds

Lorem ipsum? yes we need to make fake data for development.
Create new seeder class then register the class at DatabaseSeeder.php,
use Faker to generate many type of fake data.

If you need to generate many data, you can use factory.

For more details please check:

* [Laravel Migration](https://laravel.com/docs/5.5/migrations)
* [Laravel Seeding](https://laravel.com/docs/5.5/seeding)