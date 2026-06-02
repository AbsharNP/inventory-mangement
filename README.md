# Inventory Management API

Laravel API project for managing products, warehouse stock, dynamic pricing, and warehouse reports. The frontend has been removed; this repository is API-only.

## Included

- Database migrations for users, products, warehouses, stocks, jobs, cache, and Sanctum tokens
- Seeders with sample products, warehouses, stock records, and a demo API user
- Laravel Sanctum token authentication
- `DynamicPricingService` for stock-aware pricing
- Warehouse report endpoint with summary and near-expiring inventory
- Unit tests for dynamic pricing
- Postman collection: `Inventory_Management_API.postman_collection.json`

## Requirements

- PHP 8.3+
- Composer
- SQLite, MySQL, MariaDB, PostgreSQL, or SQL Server

## Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Create the environment file:

```bash
cp .env.example .env
php artisan key:generate
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

3. Configure your database in `.env`.

For SQLite:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

Then set:

```env
DB_CONNECTION=sqlite
```

4. Run migrations and seed sample data:

```bash
php artisan migrate --seed
```

5. Start the API server:

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.

## Demo Login

```text
email: admin@example.com
password: password
```

Call `POST /api/login` to receive a Sanctum bearer token. Use that token for protected endpoints:

```http
Authorization: Bearer <token>
Accept: application/json
```

## Endpoints

- `GET /` - API health and documentation pointer
- `POST /api/login` - Login and create Sanctum token
- `POST /api/logout` - Revoke current token
- `GET /api/products` - List products with dynamic pricing
- `POST /api/stock` - Create or update product stock in a warehouse
- `GET /api/warehouses` - List warehouses
- `GET /api/warehouses/{id}/report` - Warehouse stock report

## Dynamic Pricing Rules

- Total stock below 10: +30%
- Total stock from 10 to 50: +10%
- Total stock from 51 to 100: base price
- Total stock above 100: -20%
- Units expiring within 7 days receive an additional 25% discount price

## Warehouse Report

`GET /api/warehouses/{id}/report` returns:

- Warehouse identity
- Total product count
- Total stock quantity
- Near-expiring stock count
- Per-product stock breakdown
- Near-expiring items due within 7 days

## Tests

Run the test suite:

```bash
php artisan test
```

Run only the dynamic pricing unit test:

```bash
php artisan test --filter=DynamicPricingServiceTest
```

## Postman

Import `Inventory_Management_API.postman_collection.json` into Postman.

Recommended flow:

1. Run `Login - Get Token`
2. Copy the returned `token`
3. Set the collection variable `auth_token`
4. Call the protected product, stock, warehouse, and report endpoints
