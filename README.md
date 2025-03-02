# Boat Co API

This is the backend API for Boat Co test task, built with Laravel.

## Requirements
- PHP **8.3.17**
- Composer
- MySQL
- Node.js 
- Stripe CLI (for local Stripe webhook testing)

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/davidgrigorianc/boat-co.git
   cd boat-co
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Copy the environment file:**
   ```sh
   cp .env.example .env
   ```

4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

5. **Set up your database** in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=boatco_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run database migrations and seeders:**
   ```sh
   php artisan migrate
   php artisan db:seed
   ```

7. **Run the development server:**
   ```sh
   php artisan serve
   ```

## Additional Setup

- **If using Stripe for payments**, set your API keys in `.env`:
  ```env
  STRIPE_KEY=your_secret_key
  STRIPE_PUBLIC=your_public_key
  ```

- **Run Webhooks with Stripe CLI** :

  **Forward localhost to listen stripe webhooks**
   ```sh
   stripe listen --forward-to localhost:8000/api/stripe/webhook
   ```
  **Response should be**
- > Ready! You are using Stripe API Version [2025-02-24.acacia]. Your webhook signing secret is whsec_XXX

  **Add webhook to .env**
  ```
  STRIPE_WEBHOOK_KEY=whsec_XXX
  ```
    
## API Endpoints

- `GET /boats`               – Fetch Boats
- `POST /boats/{id}`         – Get Boat information by ID
- `POST /manufacturers`      – Get Manufacturer list
- `POST /payment-checkout`   – Create payment checkout session
- `POST /api/stripe/webhook` – Handle Stripe webhooks

## Notes
- Ensure `.env` is correctly configured before running migrations.



