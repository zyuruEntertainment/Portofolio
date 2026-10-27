# zyuruEntertainment Portfolio

Laravel portfolio site with public Home, Explore, Profile, and Projects pages plus an authenticated admin area for profile and project management.

## Local setup

Requirements: PHP 8.3 or newer and Composer.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

The project uses SQLite by default. The portfolio pages load their styles and shared theme script from `public/css` and `public/js`. `resources/css/app.css`, `resources/js/app.js`, and `vite.config.js` are the Laravel Vite starter scaffold; the current Blade pages do not reference `@vite`, so building Vite assets is not required to run the site.

Uploaded profile and project media use Laravel's `public` storage disk. The admin login route is `/admin/login`.
Provision the administrator account through the project's secure local account process before signing in.

## Checks

```powershell
php artisan route:list
php artisan test
php artisan migrate:status
```
