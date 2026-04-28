# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Monorepo with two independent parts:
- `backend/` — Laravel 11 (PHP 8.2+) API, using SQLite for local development
- `frontend/` — Flutter app (Dart SDK ^3.10.7) targeting mobile (Android/iOS) and other platforms

## Backend Commands

Run from `backend/`:

```bash
php artisan serve                                        # Start dev server at http://localhost:8000
php artisan migrate                                      # Run pending migrations
php artisan migrate:fresh --seed                        # Rebuild DB from scratch with seeders
php artisan tinker                                       # Interactive REPL

php artisan test                                         # Run all tests
php artisan test --filter=ExampleTest                   # Run a single test class
./vendor/bin/phpunit tests/Feature/ExampleTest.php      # Run a specific file

./vendor/bin/pint                                        # Fix code style (Laravel Pint)
./vendor/bin/pint --test                                 # Check style without modifying files
```

## Frontend Commands

Run from `frontend/`:

```bash
flutter pub get                          # Install dependencies
flutter run                              # Run on connected device/emulator
flutter run -d chrome                    # Run in browser

flutter test                             # Run all tests
flutter test test/widget_test.dart       # Run a single test file

flutter analyze                          # Static analysis / lint
```

## Architecture

### Backend (Laravel 11)

- **Database**: SQLite (`database/database.sqlite`) locally; `DB_CONNECTION=sqlite` in `.env`. No MySQL/Postgres configured yet.
- **Routes**: Only `routes/web.php` exists (single welcome route). No `routes/api.php` yet — create it and register in `bootstrap/app.php` when adding API endpoints.
- **Models**: `app/Models/User.php` is the only model so far.
- **Controllers**: `app/Http/Controllers/Controller.php` is only the abstract base. Add new controllers here.
- **Tests**: PHPUnit 10 with `tests/Feature/` and `tests/Unit/`. Test environment forces array cache/session and sync queue (see `phpunit.xml`).

### Frontend (Flutter)

- Entry point: `frontend/lib/main.dart` — currently the default Flutter counter scaffold.
- No state management library or HTTP client added yet; add packages to `pubspec.yaml` as the app grows.
- Platform directories (`android/`, `ios/`, `web/`, etc.) contain standard Flutter scaffolding.

### Backend–Frontend Integration

No API integration exists yet. When connecting the two, the backend base URL is `http://localhost:8000` (controlled by `APP_URL` in `backend/.env`).
