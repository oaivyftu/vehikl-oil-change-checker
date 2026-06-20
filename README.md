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

