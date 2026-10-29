# zyuruEntertainment Portfolio

Laravel portfolio site with public Home, Explore, Profile, and Projects pages plus an authenticated admin area for profile and project management.

## Local setup

Requirements: PHP 8.3 or newer and Composer.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
# Configure DB_* in .env for the MySQL database created for this app.
php artisan migrate
php artisan storage:link
php artisan serve
```

The application uses MySQL or MariaDB with InnoDB. The portfolio pages load their styles and shared theme script from `public/css` and `public/js`. `resources/css/app.css`, `resources/js/app.js`, and `vite.config.js` are the Laravel Vite starter scaffold; the current Blade pages do not reference `@vite`, so building Vite assets is not required to run the site.

Uploaded profile and project media use Laravel's `public` storage disk. The admin login route is `/admin/login`.
Create an administrator interactively with `php artisan admin:create admin@zyuru.com --name="Admin Zyuru"`; the password is entered through a hidden prompt. See [docs/mysql-deployment.md](docs/mysql-deployment.md) for database, testing, and production setup. PHPUnit uses a dedicated MySQL database named `portfolio_test` and database-backed sessions, cache, and queue, so create that test database before running the suite.

## Checks

```powershell
php artisan route:list
php artisan test
php artisan migrate:status
```
