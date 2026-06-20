# Vehikl Oil Change Checker

A small Laravel 12 application that records vehicle oil change information and reports whether an oil change is due.

## Requirements

- PHP 8.2 or newer with the SQLite extension
- Composer

## Setup

Clone the repository, change into its directory, and install the PHP dependencies:

```bash
composer install
```

Create the local environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Create the SQLite database file:

```bash
touch database/database.sqlite
```

Ensure `.env` uses SQLite:

```dotenv
DB_CONNECTION=sqlite
```

Run the database migrations:

```bash
php artisan migrate
```

Start the local development server:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

## Oil change rules

An oil change is due when either of these conditions is true:

- More than 5,000 km have been driven since the previous oil change.
- More than 6 months have passed since the previous oil change.

Exactly 5,000 km or exactly 6 months does not exceed the corresponding limit.

## Application flow

- `GET /` displays a blank oil change check form.
- `POST /check` validates and saves the submitted values.
- `GET /result/{id}` loads the saved check and displays its result.

Each result has a unique URL and remains available after a browser refresh because it is loaded from SQLite. The application intentionally has no authentication, result index, editing, or deletion features.

## Tests and code style

Run the test suite:

```bash
php artisan test
```

Check code style with Laravel Pint:

```bash
vendor/bin/pint --test
```
