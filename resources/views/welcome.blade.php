<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management & Dynamic Pricing API</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 700px;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .badge {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            margin: 15px 0;
        }

        ul {
            text-align: left;
            margin-top: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 25px;
            color: #888;
            font-size: 14px;
        }

        code {
            background: #eee;
            padding: 2px 5px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>📦 Inventory Management & Dynamic Pricing API</h1>

    <div class="badge">
        API Status: Online
    </div>

    <p>
        RESTful Laravel API for managing products, warehouses,
        stock allocation, and dynamic pricing.
    </p>

    <h3>Available Features</h3>

    <ul>
        <li>🔐 Authentication using Laravel Sanctum</li>
        <li>📦 Product Management</li>
        <li>🏭 Warehouse Management</li>
        <li>📊 Stock Tracking</li>
        <li>💰 Dynamic Pricing Engine</li>
        <li>📈 Warehouse Reports</li>
    </ul>

    <p>
        Use Postman or any API client to access the endpoints.
    </p>

    <p>
        Example: <code>/api/products</code>
    </p>

    <div class="footer">
        Laravel {{ app()->version() }} | Inventory Management API
    </div>
</div>

</body>
</html>