# User Management System

This is a **Laravel + Vue.js** based user management system that supports full CRUD operations (Create, Read, Update, Delete) for users.  
The backend provides RESTful APIs, and the frontend uses Vue.js to display and manage data.

---

## Project Setup Guide

### Prerequisites

- PHP >= 8.x
- Composer
- Node.js & npm
- MySQL (or another relational database)

---

### 1️⃣ Backend (Laravel) Setup

1. Clone the repository:
```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
```

2. Install dependencies:
```bash
composer install
```

3. Create a database named laravel

4. Configure your `.env` file with database info:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and optional seeders:
```bash
php artisan migrate
```

6. Start the backend server:
```bash
php artisan serve
```
Default URL: `http://127.0.0.1:8000`

---

### 2️⃣ Frontend (Vue.js) Setup

1. Navigate to frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Start development server:
```bash
npm run serve
```
Default URL: `http://localhost:8080`

> ⚠️ Make sure API URLs match between frontend and backend.

---

## API Endpoints

| Method | Endpoint           | Description          | Request Body / Params |
|--------|------------------|--------------------|----------------------|
| GET    | `/api/testing_users`      | Get list of users   | Optional: ?page=1    |
| POST   | `/api/testing_users`      | Create a new user   | `{ "name": "Tom", "email": "tom@test.com", "password": "123456" }` |
| GET    | `/api/testing_users/{id}` | Get single user     | -                    |
| PUT    | `/api/testing_users/{id}` | Update user info    | `{ "name": "Tommy", "email": "tommy@test.com" }` |
| DELETE | `/api/testing_users/{id}` | Delete a user       | -                    |

---

## Assumptions & Design Choices

- RESTful API design using Laravel.
- Frontend built with Vue 3 + Composition API.
- Passwords encrypted with Laravel's built-in bcrypt.
- Default pagination: 10 items per page.
- Frontend UI is simple and focuses on CRUD operations.

---

## Features

- Paginated user list view
- Create, edit, delete users
- Notifications for operation results
- Real-time data synced with backend via API

---
