# Project Setup Guide (Transfer)

This guide explains how to set up the project after transferring it to a new device.

## Prerequisites

Ensure the new device has the following installed:
- **PHP** (>= 8.1)
- **Composer** (Dependency Manager for PHP)
- **Node.js** & **NPM** (for frontend assets)
- **Database** (MySQL/MariaDB or SQLite)

## Installation Steps

1. **Extract/Copy Project**: Place the project files in your desired directory (e.g., `C:\xampp\htdocs\healthcare-project`).

2. **Install Backend Dependencies**:
   Open a terminal in the project root and run:
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**:
   Run:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   - Copy the example environment file:
     ```bash
     cp .env.example .env
     ```
     *(On Windows CMD: `copy .env.example .env`)*
   - Open `.env` and configure your database settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**:
   Set up the database tables:
   ```bash
   php artisan migrate
   ```
   *(Optional: Use `php artisan migrate --seed` to include dummy data)*

7. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

8. **Start the Server**:
   ```bash
   php artisan serve
   ```
   Access the app at `http://localhost:8000`.

## Troubleshooting
- **Permission Errors**: Ensure `storage` and `bootstrap/cache` directories are writable.
- **Missing Class/File**: Try running `composer dump-autoload`.
