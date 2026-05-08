#  NOTEBOX

> A modern note-taking web application built with Laravel & Tailwind CSS.

---

##  Tech Stack

- **Backend** — [Laravel](https://laravel.com/) (PHP)
- **Frontend** — [Tailwind CSS](https://tailwindcss.com/) +[Vite](https://vitejs.dev/)
- **Database** — MySQL / SQLite (configurable via `.env`)
- **Testing** — PHPUnit

---

##  Prerequisites

Make sure you have the following installed:

- PHP >= 8.1
- Composer
- Node.js >= 18.x & npm
- A database server (MySQL, PostgreSQL, or SQLite)

---

##  Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/notebox.git
cd notebox
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Then edit `.env` to set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notebox
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. (Optional) Seed the database

```bash
php artisan db:seed
```

---

##  Running the App

### Development

```bash
# Start Laravel dev server
php artisan serve

# In a separate terminal — compile assets with hot reload
npm run dev
```

The app will be available at **http://localhost:8000**

### Production build

```bash
npm run build
```

---

##  Running Tests

```bash
php artisan test
# or
./vendor/bin/phpunit
```

---



<p align="center">Made with ❤️ using Laravel</p>
