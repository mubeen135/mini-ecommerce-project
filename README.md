# Mini E-commerce

A simple e‑commerce website built with Laravel, featuring product listing, AJAX shopping cart, and Stripe payment integration.

## Features

- Product listing page with 6 seeded products
- Add/remove products to cart with AJAX (no page reload)
- Update cart quantities dynamically
- Stripe Checkout for secure payments (test mode)
- Orders saved in database

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL (or SQLite)
- Stripe test account (for API keys)

## Installation

1. **Clone the repository**

    git clone <https://github.com/mubeen135/mini-ecommerce-project.git>
    cd mini-ecommerce

2. **Install PHP dependencies**

    composer install

3. **Environment setup**

    Copy .env.example to .env

    Generate application key:
    php artisan key:generate

4. **Database configuration**

    Create a database (e.g., mini_ecommerce)
    Update .env with your database credentials:

    DB_DATABASE=mini_ecommerce
    DB_USERNAME=root
    DB_PASSWORD=

5. **Run migrations and seeders**

    php artisan migrate --seed

6. **Add Stripe keys**

    STRIPE_KEY=your_stripe_key_here
    STRIPE_SECRET=your_stripe_key_here

7. **Start the server**

    php artisan serve
