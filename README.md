# apex_laravel_test
# Laravel Project Documentation

This project is built with Laravel, offering a robust set of APIs for user management and authentication.

## Setup Instructions

1. **Clone the repository:**

```bash
git clone <repository-url>
```

2. **Install dependencies:**
Navigate into your project directory and install the Composer dependencies:
```bash
cd <project-directory>
composer install
```

3. **Environment Configuration:**
Copy ```.env.example``` to ```.env``` and configure your environment variables, including database connections:

```bash
cp .env.example .env
```

4. **Generate Application Key:**
Generate a new application key:

```bash
php artisan key:generate
```

5 **Database Migrations and Seeding:**
Run migrations to create the database schema:

```bash
php artisan migrate
```

6. **Running the Server**
Start the Laravel development server:

```bash
php artisan serve
```
Your application will be accessible at http://127.0.0.1:8000.

7. **Running Tests**
To run the PHPUnit tests included with your Laravel application:

```bash
php artisan test
```
Or with verbose output:

```bash
vendor/bin/phpunit --verbose
```

**API Endpoints**
The following endpoints are available:

**Authentication**

```bash
POST /api/v1/auth/login - Log in a user
POST /api/v1/auth/register - Register a new user

User Management (Authenticated)

GET /api/v1/user/users - List all users
GET /api/v1/user/users/{id} - Get details of a specific user
POST /api/v1/user/users - Create a new user
PUT /api/v1/user/users/{id} - Update an existing user
DELETE /api/v1/user/users/{id} - Delete a user(Admin Only)

//Admin (Authenticated, Admins only)

GET /api/v1/admin/user/all - List all users (Admin)
GET /api/v1/admin/user/one/{user} - Get one user (Admin)
POST /api/v1/admin/user/create - Create a user (Admin)
POST /api/v1/admin/user/edit/{user} - Edit a user (Admin)
DELETE /api/v1/admin/user/delete/{user} - Delete a user (Admin)
```
