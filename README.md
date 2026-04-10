# VernonEdu

Project **VernonEdu** adalah aplikasi web berbasis **Laravel 12 + React + Vite + TailwindCSS**.

---

# Requirements

Pastikan software berikut sudah terinstall di komputer:

* PHP **8.2+**
* Composer
* Node.js **18+**
* npm
* MySQL / MariaDB
* Web server (Laragon / XAMPP / Apache / Nginx)

---

# Installation

Clone project:

```bash
git clone [project]
cd project
```

Install dependency backend (Laravel):

```bash
composer install
```

Install dependency frontend (React):

```bash
npm install
```

---

# Environment Setup

Copy file environment:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

# Database Setup

Sesuaikan konfigurasi database di file `.env`:

```env
DB_DATABASE=vernonedu
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration:

```bash
php artisan migrate
```

---

# Running the Project

Jalankan Laravel server:

```bash
php artisan serve
```

Jalankan Vite (React):

```bash
npm run dev
```

---

# Access Application

Buka di browser:

```
http://127.0.0.1:8000
```

---

# Tech Stack

Backend

* Laravel 12
* Laravel Sanctum

Frontend

* React
* React Router
* Axios
* TailwindCSS

Build Tool

* Vite

---

# Project Structure (Simplified)

```
app/
routes/
resources/
 └── js
     ├── components
     ├── pages
     └── router.jsx

vendor/
node_modules/
```

---

# Notes

Jika dependency belum terinstall atau project error, jalankan ulang:

```bash
composer install
npm install
```