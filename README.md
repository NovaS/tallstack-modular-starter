# TALL Stack Modular Starter

A robust, production-ready starter kit built for modern web development using the **TALL stack** (Tailwind CSS v4, Alpine.js via Livewire 4, Laravel 13, and TallStackUI v4). 

This project provides a clean, modular architecture that allows you to scale effortlessly by organizing features into self-contained modules.

---

## Key Features

- **TALL Stack Integration**: Tailwind CSS v4, Alpine.js (bundled with Livewire 4), and TallStackUI v4 components pre-configured.
- **Modular Architecture**: Features are organized in `app/Modules/{Module}`, enabling cleaner code separation and better maintainability.
- **Service-Oriented Design**: Uses `Services/` to encapsulate business logic, keeping your controllers and UI layer lightweight.
- **Configurable Authentication**: Easily switch between `email` or `username` as the login identifier via `AUTH_LOGIN_ID` in your `.env` file.
- **Spatie Permissions**: Integrated with Spatie Laravel-Permission for robust, role-based access control.

---

## Getting Started

To get started with this starter kit:

1. Clone the repository.
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and set up your database.
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Build frontend assets:
   ```bash
   npm run build
   ```

---

## Guide to Expanding This Project

This project uses a **Modular Architecture (`app/Modules/{Module}`)** with `Services/` to encapsulate business logic.

### Adding New Domain Modules

Create a directory under `app/Modules/{Module}` (e.g., `app/Modules/AccessControl` or `app/Modules/Billing`). [`ModuleServiceProvider`](app/Providers/ModuleServiceProvider.php) automatically discovers and registers it:

- `app/Modules/{Module}/Services/` — Domain business logic (e.g., `AuthService`).
- `app/Modules/{Module}/routes.php` — Loaded under the `web` middleware group.
- `app/Modules/{Module}/Views/` — Registered under a kebab-case Blade namespace (e.g., `view('access-control::index')`).
- `app/Modules/{Module}/Livewire/` — Registered as a Livewire 4 namespace (e.g., `<livewire:access-control::role-table />`).

---

## Changes Made

1. **Modular Architecture (`app/Modules/{Module}` with `Services/`)**
   - Created [`ModuleServiceProvider`](app/Providers/ModuleServiceProvider.php) to auto-discover modules under `app/Modules/*`.
   - Organized the **`Auth` Module** (`app/Modules/Auth`) with `AuthService`, controllers, requests, and views.
   - Organized the **`Dashboard` Module** (`app/Modules/Dashboard`) with `dashboard::index` and module-specific routes.

2. **Standard Laravel `users` Table, Configurable Login ID (`email` or `username`), & Spatie Permission Setup**
   - Implemented standard [database/migrations/0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php).
   - Configurable login identifier via `AUTH_LOGIN_ID` in `.env` and `User::loginField()`.
   - Configured Spatie `laravel-permission` using `model_id` morph key.

3. **TALL Stack & TallStackUI v4 Configuration**
   - Configured Vite and Tailwind CSS v4 in [resources/css/app.css](resources/css/app.css).
   - Set up layouts in `resources/views/layouts/` with TALL stack assets and components.

---

## Validation Results

- **Frontend Build**: Compiled cleanly with Vite v8.3.6 and `@tailwindcss/vite` v4.3.4.
- **Test Suite**: `10 passed (55 assertions)` in `AuthenticationTest`.
- **Code Style**: Checked and fixed via `pint`.

---

## Optimization & Deployment

1. **Configure `.env`**  
  >* Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, `AUTH_LOGIN_ID`  
  >* Switch `CACHE_STORE`, `SESSION_DRIVER`, and `QUEUE_CONNECTION` from `database` ([.env.example](.env.example)) to `redis`.
2. **Install & build assets**  
  >* `composer install --no-dev --optimize-autoloader`  
  >production PHP autoloading
  >* `npm ci && npm run build`  
  >minified Vite/Tailwind assets.
3. **Migrate & cache** **[NOT IN PRODUCTION! CAN OVERWRITE EXISTING DB]**  
  >* Run `php artisan migrate --force` and `php artisan optimize` (avoid closure routes in `app/Modules/{Module}/routes.php` so route caching works).
4. **Reset permission cache** **[OPTIONAL]**  
>* Run `php artisan permission:cache-reset`  
>if roles or permissions are seeded during deploy.  
5. **Configure web server**  
>* Point your web server root to `public/` and enable PHP OPcache.

---

## Contributing & License

This project is built on the Laravel framework. The framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
