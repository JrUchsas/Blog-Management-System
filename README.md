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

---

# Codebase Explanation Guide

It explains what this codebase is, how the project is structured, what every folder and custom file does, and how the different pieces (routes, controllers, models, and views) talk to each other.

---

## 1. What is PHP and Laravel?

Before diving into the files, let's establish some foundational terms:

*   **PHP:** A backend programming language. This means it runs on the web server (not in the browser), talks to the database, checks if passwords are correct, processes file uploads, and generates the raw HTML webpage that is sent to the user.
*   **Laravel:** A PHP **Framework**. Think of a framework as a pre-built house structure. Instead of building walls, plumbing, and electrical outlets from scratch, Laravel provides those utilities for free. It gives us pre-packaged security, database tools, and routing, so we can focus on building the blog itself.
*   **MVC (Model-View-Controller):** The design pattern Laravel uses to separate code logic:
    *   **M**odel: Talks to the Database (the data).
    *   **V**iew: What the user sees (the HTML layout).
    *   **C**ontroller: The brain. It sits between the Model and View. It receives a request from the user, retrieves data from the Model, and passes it to the View.

---

## 2. Directory Structure Overview

If you open the project, you will see a lot of folders. Here is what the most important ones do:

*   📂 **`app/`**: Contains the main PHP logic. Inside `app/Http/Controllers/` are the brains (Controllers), and inside `app/Models/` are the files that represent database tables.
*   📂 **`bootstrap/`**: Used by Laravel to start up (bootstrap) the application. You don't need to change files here.
*   📂 **`config/`**: Contains configuration files (database connections, app settings, mail drivers, etc.).
*   📂 **`database/`**: Contains database-related files:
    *   📂 **`migrations/`**: Code scripts that automatically build and structure your database tables.
*   📂 **`public/`**: The starting point of the application. Images, CSS styling stylesheets, and JavaScript files are stored here because they are accessible directly by browsers.
*   📂 **`resources/`**: Where the front-end code lives:
    *   📂 **`views/`**: Contains `.blade.php` files (templates for HTML rendering).
*   📂 **`routes/`**: Contains routing files:
    *   📄 **`web.php`**: The list of all URL endpoints (e.g. `/login`, `/admin/dashboard`) and what controller should run when they are visited.
*   📂 **`storage/`**: Where Laravel stores internal files, logs, and temporary uploads.
*   📄 **`.env`**: The configuration file containing database passwords, app environment states, and server ports.

---

## 3. How a Web Request Works (The Lifecycle)

Imagine a user clicks **"Category List"** in the sidebar. Here is the step-by-step journey of that action:

```
[ User Browser ]
       │
       ▼ (1. Clicks Link /admin/categories)
[ routes/web.php ] ◄─── Checks which URL matches
       │
       ▼ (2. Passes to auth middleware to ensure user is logged in)
[ Middleware ]
       │
       ▼ (3. Calls CategoryController@index method)
[ CategoryController ] ◄─── Requests category data ───► [ BlogCategory Model ]
       │                                                          │
       ▼ (5. Packages categories and sends to view)               ▼ (4. Queries SQL Database)
[ index.blade.php ] ◄─── Renders HTML templates              [ MySQL Database ]
       │
       ▼ (6. Sends generated HTML back to browser)
[ User Browser ]
```

---

## 4. Deep-Dive: Explanation of Every Custom File

Here is the explanation of all files created or modified for this system.

---

### 📂 Database & Models (Data Layer)

#### 1. 📄 `database/migrations/2026_06_30_202355_create_blog_categories_table.php`
*   **What it does:** Tell the database how to build the `blog_categories` table.
*   **Plain English:** It specifies that this table has an `id` (unique counter), a `name` (required text, unique so two categories can't share a name), and a `status` (which can only be 'Active' or 'Inactive', default 'Active').

#### 2. 📄 `database/migrations/2026_06_30_202401_create_blogs_table.php`
*   **What it does:** Build the `blogs` table.
*   **Plain English:** It specifies that a blog needs a `category_id` (so it knows which category it belongs to), a `title` (text), a `slug` (the URL-friendly name, e.g. `my-first-blog`), `details` (text for content), an `image` (stores file path), and a `status` ('Active'/'Inactive'). If a category is deleted, this code deletes all blogs in that category automatically (`onDelete('cascade')`).

#### 3. 📄 `app/Models/BlogCategory.php`
*   **What it does:** Acts as the PHP link to the `blog_categories` database table.
*   **Plain English:** Instead of writing complex database SQL code, we write `$category->name`. It also defines a relationship: `blogs()` telling Laravel that one category "has many" blogs.

#### 4. 📄 `app/Models/Blog.php`
*   **What it does:** The PHP link to the `blogs` database table.
*   **Plain English:** Defines database fields we are allowed to save (`fillable`). It also contains a `category()` function, establishing that a blog post "belongs to" a category.

---

### 📂 Controllers (The Brains)

#### 1. 📄 `app/Http/Controllers/AuthController.php`
*   **What it does:** Manages Login, Registration, Logout, and Changing Passwords.
*   **Plain English:**
    *   `register()` checks if the user submitted a valid name, email, and password. If yes, it encrypts the password (`Hash::make`), saves the user, and logs them in.
    *   `login()` checks if the email and password submitted match the database records. If they match, a secure session starts.
    *   `logout()` destroys the login session so the user must log in again.
    *   `changePassword()` checks if the user's current password is correct, then saves their new one.

#### 2. 📄 `app/Http/Controllers/DashboardController.php`
*   **What it does:** Computes what goes on the home screen of the admin panel.
*   **Plain English:** It counts how many categories, blogs, and users exist in the database. It then gets the 5 latest blogs and 5 latest registered users and hands them over to the dashboard page to display.

#### 3. 📄 `app/Http/Controllers/CategoryController.php`
*   **What it does:** Directs the CRUD (Create, Read, Update, Delete) pages for Blog Categories.
*   **Plain English:**
    *   `index()` searches the database for categories matching a search query, splits them into pages (pagination), and displays them.
    *   `store()` validates the new category (checks if name is unique/required) and saves it.
    *   `update()` saves changes when a user edits a category name or toggles status.
    *   `destroy()` deletes the category from the database.

#### 4. 📄 `app/Http/Controllers/BlogController.php`
*   **What it does:** Manages Blog posts, including uploading images.
*   **Plain English:**
    *   `store()` verifies the title, details, and category. It checks if the image uploaded is valid (format is JPEG/JPG/PNG/WebP, and size is under 2 MB). It saves the image to `public/uploads/blog/` and writes the path to the database.
    *   `update()` does the same as store, but if a new image is uploaded, it deletes the old file from the server's storage first.
    *   `destroy()` deletes the blog post and its image file from storage.

---

### 📂 Routes (URL Director)

#### 1. 📄 `routes/web.php`
*   **What it does:** Map web URLs to Controller functions.
*   **Plain English:**
    *   If a guest visits `/login`, it points them to `AuthController@showLoginForm`.
    *   If they visit `/admin/dashboard`, it checks if they are logged in. If they are, it goes to `DashboardController@index`. If they are not, they get booted back to the login screen.
    *   `Route::resource` is a shortcut that automatically generates all routes for listing, adding, editing, and deleting categories/blogs.

---

### 📂 Views & Styling (Frontend)

Laravel uses **Blade** templates (`.blade.php`). Blade is HTML with special powers. It lets us write PHP logic (like loops and conditions) inside our HTML layout using simple syntax like `@if` or `@foreach`.

#### 1. 📄 `resources/views/layouts/admin.blade.php`
*   **What it does:** The main template for the admin dashboard.
*   **Plain English:** It defines the sidebar menu (Dashboard, Category, Blog, Profile), the top navigation bar, and imports Bootstrap 5. It uses `@yield('content')` as a placeholder where other pages (like the blog list or category list) inject their specific HTML.

#### 2. 📄 `resources/views/auth/login.blade.php` & `register.blade.php`
*   **What they do:** Forms for logging in or signing up.
*   **Plain English:** Styled input forms displaying error messages if validation fails (e.g. "This email is already registered").

#### 3. 📄 `resources/views/admin/dashboard.blade.php`
*   **What it does:** The dashboard homepage.
*   **Plain English:** Displays three colored visual widgets (stat cards) for categories, blogs, and users. Below them are tables showing the latest registered users and blog posts.

#### 4. 📂 Category Views (`index.blade.php`, `create.blade.php`, `edit.blade.php`)
*   **What they do:** Interface forms to list, create, and update categories.

#### 5. 📂 Blog Views (`index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`)
*   **What they do:** Interfaces for blog management.
    *   `create.blade.php` integrates **CKEditor 5** (which turns a regular text area into a rich Word-like text editor) and has JavaScript that takes whatever you type in the title box, converts it to lowercase with dashes, and fills in the `slug` box automatically in real-time.
    *   `show.blade.php` renders the blog page details and displays the uploaded featured image.

#### 6. 📄 `public/css/admin.css`
*   **What it does:** Adds custom styles to the website.
*   **Plain English:** It overrides the default browser look with modern typography (Outfit font from Google), glassmorphic rounded cards, deep slate colored sidebar navigation, animations, and hover transitions.

---

## 5. Summary of Terms

*   **CSRF Token (`@csrf`):** A security code Laravel generates automatically inside forms. It prevents malicious websites from forging requests to your server.
*   **Middleware:** A checkpoint guard. The `auth` middleware checks if you are logged in before letting you access the dashboard.
*   **Slug:** The part of a URL that identifies a page in human-readable words (e.g. `/blogs/my-first-trip` instead of `/blogs/id=12`).
*   **Validation:** Checking if user inputs are correct (e.g. check if email contains `@`, check if file uploaded is a real image).
*   **Pagination:** Splitting a huge list of items across multiple pages (Page 1, Page 2, etc.) so the site loads fast.
