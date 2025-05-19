# Laravel 12 Posting System

A simple posting system built with **Laravel 12**. This application allows users to create, read, update, and delete posts. The guide below provides setup instructions for **Windows**, **macOS**, and **Linux** environments.

---

## 🚀 Features

- Laravel 12 with Vite
- CRUD functionality for posts
- MySQL database integration
- Local development setup for all major operating systems

---

## 🧰 Requirements

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM
- Laravel CLI
- Git (optional)

---

## 📥 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/cj-travis/laravel-posting-system.git
cd laravel-posting-system
```

### Step 2: Copy Environment File

#### Windows:

```bash
copy .env.example .env
```

#### macOS / Linux:

```bash
cp .env.example .env
```

### Step 3: Update `.env` File

Edit the `.env` file and set your database configuration:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_posting_system
DB_USERNAME=root
DB_PASSWORD=
```

```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<get your own keys from mailtrap>
MAIL_PASSWORD=<get your own keys from mailtrap>
MAIL_FROM_ADDRESS="savenshare@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 💻 Setup by OS

### 🪟 Windows (using XAMPP)

1. Start Apache and MySQL in XAMPP.
2. Create a database named `laravel_posting_system` via phpMyAdmin.
3. Run the following commands:

```bash
composer install
npm install
npm run dev
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

4. Visit [http://localhost:8000](http://localhost:8000) to view your app.

---

### 🍎 macOS / 🐧 Linux

1. Start MySQL:
   - macOS (Homebrew): `brew services start mysql`
   - Linux (Ubuntu/Debian): `sudo service mysql start`

2. Create a database using your preferred method (CLI or GUI).

3. Run the following commands:

```bash
composer install
npm install
npm run dev
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

4. Open [http://localhost:8000](http://localhost:8000) in your browser.

---

## ⚙️ Build Frontend Assets

- Development:  
  ```bash
  npm run dev
  ```

- Production:  
  ```bash
  npm run build
  ```

Vite is used in Laravel 12 for frontend bundling.

---

## 📁 Directory Structure

```
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── .env
└── vite.config.js
```

---

## 📝 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🌐 Author

- GitHub: [@cj-travis](https://github.com/cj-travis)
