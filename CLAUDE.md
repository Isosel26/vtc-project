# CLAUDE.md — VTC Project

## Project Overview

This is a **VTC (Véhicule de Transport avec Chauffeur)** ride-hailing application — a platform connecting clients who request rides with chauffeurs who accept them.

The project is a full-stack monorepo with:
- **Backend**: Laravel 12 REST API (PHP 8.2+)
- **Frontend**: Vue 3 SPA bundled via Vite, served by Laravel

The actual application code lives inside the `vtc-project/` subdirectory:
```
vtc-project/          ← git root
└── vtc-project/      ← Laravel application root (run all commands from here)
```

---

## Tech Stack

| Layer        | Technology                              |
|--------------|-----------------------------------------|
| Backend      | Laravel 12, PHP 8.2+                    |
| Auth         | Laravel Sanctum (token-based API auth)  |
| ORM          | Eloquent                                |
| Database     | SQLite (default), configurable via .env |
| Frontend     | Vue 3 (Options API), Vue Router 4       |
| Styling      | Tailwind CSS v4                         |
| Build tool   | Vite 6 + laravel-vite-plugin            |
| HTTP client  | Axios                                   |
| Testing      | PHPUnit 11                              |
| Code style   | Laravel Pint                            |

---

## Directory Structure

```
vtc-project/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Register/login/logout for Client & Chauffeur
│   │   └── CourseController.php    # Course CRUD (create, list, accept, show)
│   ├── Models/
│   │   ├── Client.php              # Client user model (HasApiTokens)
│   │   ├── Chauffeur.php           # Chauffeur user model (HasApiTokens)
│   │   ├── Course.php              # Ride/course model
│   │   └── User.php                # Default Laravel user (not used for auth)
│   └── Providers/
├── config/                         # Laravel config files
├── database/
│   ├── migrations/                 # Schema migrations (run in order)
│   └── seeders/
├── resources/
│   ├── css/app.css                 # Tailwind entry point
│   ├── js/
│   │   ├── app.js                  # Vue app bootstrap
│   │   ├── App.vue                 # Root Vue component (router-view only)
│   │   ├── bootstrap.js            # Axios setup
│   │   ├── router/index.js         # Vue Router route definitions
│   │   └── components/
│   │       ├── Home.vue
│   │       ├── Login.vue
│   │       ├── Register.vue
│   │       ├── CourseRequest.vue   # Client: request a new ride
│   │       ├── CourseList.vue      # Chauffeur: browse available rides
│   │       └── ChauffeurCourses.vue # Chauffeur: dashboard with accept action
│   └── views/welcome.blade.php    # Single Blade view that loads the Vue SPA
├── routes/
│   ├── api.php                     # All API routes
│   └── web.php                     # Catches all routes → serves Vue SPA
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

---

## Domain Model

### Entities

**Client** (`clients` table)
- `id`, `name`, `email`, `password`, `remember_token`, `timestamps`
- Extends `Authenticatable`, uses `HasApiTokens`

**Chauffeur** (`chauffeurs` table)
- `id`, `name`, `email`, `password`, `remember_token`, `timestamps`
- Extends `Authenticatable`, uses `HasApiTokens`

**Course** (`courses` table) — a ride request
- `id`, `client_id` (FK → clients), `chauffeur_id` (FK → chauffeurs, nullable)
- `departure` (string), `destination` (string), `scheduled_at` (datetime)
- `status`: `pending` | `accepted` | `finished` (default: `pending`)
- `timestamps`

### Relationships
- `Course` belongs to `Client` and optionally to `Chauffeur`
- `Client`/`Chauffeur` have no inverse relationship defined (add as needed)

---

## API Routes

All routes are prefixed with `/api` (set in `bootstrap/app.php`).

### Public routes
| Method | Path                    | Controller Action          | Description                  |
|--------|-------------------------|----------------------------|------------------------------|
| POST   | `/api/register/client`  | `AuthController@registerClient`  | Register a new client  |
| POST   | `/api/register/chauffeur` | `AuthController@registerChauffeur` | Register a chauffeur |
| POST   | `/api/login`            | `AuthController@login`     | Login (client or chauffeur)  |

### Protected routes (require `Authorization: Bearer <token>`)
| Method | Path                        | Controller Action                | Description                    |
|--------|-----------------------------|----------------------------------|--------------------------------|
| POST   | `/api/logout`               | `AuthController@logout`          | Invalidate current token       |
| POST   | `/api/courses`              | `CourseController@createCourse`  | Client creates a ride request  |
| GET    | `/api/courses`              | `CourseController@listCourses`   | Chauffeur lists pending rides  |
| GET    | `/api/courses/{id}`         | `CourseController@showCourse`    | Show a single course           |
| POST   | `/api/courses/{id}/accept`  | `CourseController@acceptCourse`  | Chauffeur accepts a ride       |

### Login response shape
```json
{ "access_token": "<token>", "role": "client|chauffeur" }
```

---

## Frontend Routes (Vue Router)

| Path                  | Component           | Access         |
|-----------------------|---------------------|----------------|
| `/`                   | Home                | Public         |
| `/login`              | Login               | Public         |
| `/register`           | Register            | Public         |
| `/client`             | CourseRequest       | Client only    |
| `/chauffeur`          | CourseList          | Chauffeur only |
| `/chauffeur/dashboard`| ChauffeurCourses    | Chauffeur only |

Auth state is stored in `localStorage`:
- `access_token` — Sanctum bearer token
- `user_role` — `"client"` or `"chauffeur"`

> **Note**: No route guards are currently implemented. Role-based access is only enforced on the backend.

---

## Development Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ and npm
- SQLite (bundled with PHP, no separate install needed)

### Initial setup
```bash
cd vtc-project

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Create SQLite database and run migrations
touch database/database.sqlite
php artisan migrate
```

### Run development servers (all at once)
```bash
composer run dev
# Starts: php artisan serve, queue:listen, pail (log viewer), and vite dev server
```

Or run individually:
```bash
php artisan serve          # Laravel backend on http://localhost:8000
npm run dev                # Vite HMR dev server
```

### Build for production
```bash
npm run build              # Compiles and hashes frontend assets to public/build/
```

---

## Database Migrations

Run in this order (already handled by `php artisan migrate`):

1. `0001_01_01_000000` — create `users` table
2. `0001_01_01_000001` — create `cache` table
3. `0001_01_01_000002` — create `jobs` table
4. `2025_03_20_105339` — create `clients` table
5. `2025_03_20_110026` — create `chauffeurs` table
6. `2025_03_20_110045` — create `courses` table
7. `2025_03_20_110845` — create `personal_access_tokens` table (Sanctum)
8. `2025_03_31_*` — add `client_id`, `departure`, `destination`, `scheduled_at`, `status` to courses

When adding new fields, **always create a new migration** rather than modifying existing ones.

---

## Testing

```bash
cd vtc-project

# Run all tests
php artisan test

# Or directly with PHPUnit
./vendor/bin/phpunit

# Run only a specific suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

Tests are configured in `phpunit.xml`. The test environment uses:
- `APP_ENV=testing`
- `CACHE_STORE=array`
- `SESSION_DRIVER=array`
- `QUEUE_CONNECTION=sync`

> **Note**: SQLite in-memory DB (`DB_DATABASE=:memory:`) is commented out in `phpunit.xml`. Enable it for faster, isolated tests.

---

## Code Style

Format PHP code with **Laravel Pint**:
```bash
cd vtc-project
./vendor/bin/pint              # Fix all files
./vendor/bin/pint --test       # Check without fixing
```

Pint follows the Laravel preset (PSR-12 based). No separate config file — uses defaults.

---

## Authentication Architecture

This app uses **two separate authenticatable models** instead of a single `User` model:

- `App\Models\Client` — stored in `clients` table
- `App\Models\Chauffeur` — stored in `chauffeurs` table

Both extend `Illuminate\Foundation\Auth\User` (Authenticatable) and use `HasApiTokens` from Sanctum.

The login endpoint tries `Client` first, then `Chauffeur`. The response includes a `role` field so the frontend can branch behavior accordingly.

> **Important**: The default `App\Models\User` and `users` table exist but are **not used** for authentication in this app.

### Sanctum multi-guard setup

The `auth:sanctum` middleware resolves the authenticated user from the `personal_access_tokens` table. Because `Client` and `Chauffeur` are separate morphable models, Sanctum handles them transparently via the `tokenable` polymorphic relation.

---

## Key Conventions

### Backend (PHP/Laravel)
- Follow PSR-12 / Laravel coding standards
- Use `$fillable` on all models (mass assignment protection is enabled)
- Validation happens in controllers via `$request->validate()`
- Return JSON responses from all API controllers
- Use `response()->json($data, $statusCode)` consistently
- Comments and error messages are written in **French** (project language)
- Date format for `scheduled_at` field: `Y-m-d H:i:s` (server-side validation enforces this)

### Frontend (Vue 3)
- Uses the **Options API** (not Composition API) — keep new components consistent
- Components use `<script>` with `export default { name, data(), methods }` pattern
- Scoped styles (`<style scoped>`) are used in components
- API base URL is hardcoded as `http://localhost:8000` — consider moving to an env var (`VITE_API_URL`)
- Auth token is read from `localStorage.getItem('access_token')` in each component method that needs it

### Database
- Use Eloquent migrations for all schema changes
- Foreign keys follow convention: `{model}_id` (e.g., `client_id`, `chauffeur_id`)
- Soft deletes are not currently used

---

## Environment Variables

Key variables to configure in `.env` (copy from `.env.example`):

```dotenv
APP_KEY=          # Generate with: php artisan key:generate
APP_URL=http://localhost

DB_CONNECTION=sqlite
# For MySQL/PostgreSQL, uncomment and set:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=vtc
# DB_USERNAME=root
# DB_PASSWORD=

VITE_APP_NAME="${APP_NAME}"
```

---

## Known Issues / Areas for Improvement

- **Hardcoded API URL** in Vue components (`http://localhost:8000`) — should use `import.meta.env.VITE_API_URL`
- **No frontend route guards** — any user can navigate to `/client` or `/chauffeur` routes regardless of role
- **No role enforcement** in `CourseController` — a chauffeur can currently call `POST /api/courses` (client action) and vice versa
- **`password_confirmation` missing** from chauffeur registration validation (client registration requires it)
- **No tests** for the domain logic — only the default Laravel example tests exist
- The `User` model / `users` table is unused for auth but still present
