# Blog Management System

A premium, secure Blog Management System built with **PHP (Laravel)**, **MySQL**, and **Bootstrap 5**.

---

## 🚀 Quick Start Guide

Follow these steps to run the application on your computer:

### 1. Prerequisites
Ensure you have **PHP (>= 8.2)**, **Composer**, and **MySQL** (or XAMPP) installed on your machine.

### 2. Install Project Dependencies
Open your command line in the project folder and run:
```bash
composer install
```

### 3. Setup Your Environment File
1. Copy the `.env.example` file and rename it to `.env`.
2. Open the `.env` file and verify or change the database connection details:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 4. Generate the Application Key
Run this command to create a secure application encryption key:
```bash
php artisan key:generate
```

### 5. Create the Database
Start your local MySQL server (e.g. in the XAMPP Control Panel) and create a database named `blog_system` (or run in MySQL console: `CREATE DATABASE blog_system;`).

### 6. Run Migrations
Run this command to automatically generate the database tables (`users`, `blog_categories`, and `blogs`):
```bash
php artisan migrate
```

### 7. Start the Local Server
Run this command to start the Laravel development server:
```bash
php artisan serve
```
Open your browser and navigate to **`http://127.0.0.1:8000`**. You will be automatically redirected to the Login page. Click **Register** at the bottom to sign up for your administrator account!


