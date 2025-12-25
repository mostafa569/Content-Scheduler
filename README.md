# Social Media Scheduler

A robust, clean, and extensible Laravel-based RESTful API for scheduling and managing social media posts across multiple platforms. Users can register, connect platforms, create and schedule posts, toggle platform availability, and view basic analytics.

## Features

- User registration and login with Sanctum token authentication
- CRUD operations for posts (create, read, update, delete)
- Schedule posts for automatic future publishing
- Attach multiple social media platforms to each post
- Per-user platform connection management (toggle active/inactive)
- Basic analytics: posts per platform, success rate, scheduled vs published counts
- Queue-based post publishing simulation 
- Layered architecture: Controllers → Services → Repositories

## Tech Stack

- Laravel 12
- Laravel Sanctum (API token authentication)
- MySQL / PostgreSQL
- PHP ≥ 8.1
- Queue system

## Database Structure

### Key Tables

1. **users**  
   Standard Laravel users table (`id`, `name`, `email`, `password`, `timestamps`)

2. **platforms**  
   - `id` (bigint)
   - `name` (string, e.g., "Twitter", "Facebook", "LinkedIn")
   - `timestamps`

3. **posts**  
   - `id` (bigint)
   - `user_id` (foreign key → users)
   - `content` (text)
   - `status` (enum: 'scheduled', 'published', 'failed')
   - `scheduled_time` (datetime)
   - `timestamps`

4. **platform_user** (pivot table)  
   - `user_id` (foreign key)
   - `platform_id` (foreign key)
   - `active` (boolean, default: true)
   - `timestamps`

5. **post_platform** (pivot table)  
   - `post_id` (foreign key)
   - `platform_id` (foreign key)
   - `platform_status` (enum: 'pending', 'published', 'failed', default: 'pending')
   - `timestamps`

### Relationships

- User ↔ Platform: many-to-many (with `active` pivot attribute)
- Post ↔ Platform: many-to-many (with `platform_status` pivot attribute)
- User → Post: one-to-many

## Migrations

Create the following migration files using `php artisan make:migration`:

```bash
php artisan make:migration create_platforms_table
php artisan make:migration create_platform_user_table
php artisan make:migration create_posts_table
php artisan make:migration create_post_platform_table
```

## Installation & Setup

### Prerequisites

- PHP ≥ 8.1
- Composer
- MySQL/PostgreSQL

### Steps

1. **Clone the repository**

```bash
git clone https://github.com/mostafa569/Content-Scheduler.git
cd Content-Scheduler
```

2. **Install dependencies**

```bash
composer install
```

3. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**

Edit `.env` file with your database credentials:
```env
DB_CONNECTION=your_database_connection
DB_HOST=your_database_host
DB_PORT=your_database_port
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

5. **Run migrations and seeders**

```bash
php artisan migrate
php artisan db:seed
```

6. **Run scheduled posts command (Testing)**

```bash
php artisan posts:publish
```

7. **Start queue worker**

```bash
php artisan queue:work
```

8. **Start development server**

```bash
php artisan serve
```

### API Testing

Import the provided Postman collection:
- `Content-Scheduler.postman_collection.json`


### Thanks ----->>> @mostafa569