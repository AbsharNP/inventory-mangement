<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management & Dynamic Pricing API</title>

    <style>
        /* Modern Reset & Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f8fafc; /* Soft slate background */
            color: #334155;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Responsive Card Container */
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 640px;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 
                        0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        /* Header Layout */
        .header-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        h1 {
            color: #0f172a;
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }

        /* Clean Technical Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 9999px;
        }

        .badge::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #16a34a;
            border-radius: 50%;
        }

        /* Description Paragraphs */
        p {
            color: #475569;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        h3 {
            color: #1e293b;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Feature List using CSS Grid */
        ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 12px;
            margin-bottom: 2rem;
        }

        li {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #edf2f7;
            font-size: 0.95rem;
            color: #334155;
            font-weight: 500;
        }

        /* Enhanced Code Blocks */
        .endpoint-box {
            background: #0f172a;
            color: #38bdf8;
            padding: 14px 18px;
            border-radius: 8px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.9rem;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow-x: auto;
        }

        .endpoint-box code {
            color: #e2e8f0;
        }
        
        .method {
            background: #0ea5e9;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 8px;
        }

        /* Subtle Professional Footer */
        .footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Responsive Breakpoints */
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            .card {
                padding: 1.5rem;
                border-radius: 12px;
            }
            h1 {
                font-size: 1.5rem;
            }
            ul {
                grid-template-columns: 1fr;
            }
            .footer {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="card">
    <div class="header-group">
        <span class="badge">API Status: Online</span>
        <h1>Inventory Management & Dynamic Pricing API</h1>
    </div>

    <p>
        A production-ready, RESTful Laravel API tailored for handling localized product distributions, smart warehouse stock allocation, and real-time dynamic pricing engines.
    </p>

    <h3>Available Features</h3>
    <ul>
        <li>🔐 Authentication via Sanctum</li>
        <li>📦 Product Management</li>
        <li>🏭 Warehouse Control</li>
        <li>📊 Stock Allocation Tracking</li>
        <li>💰 Dynamic Pricing Engine</li>
        <li>📈 Real-time Stock Reports</li>
    </ul>

    <p>
        Integrate smoothly by consuming our standard resource endpoints via Postman or your preferred API client:
    </p>

    <div class="endpoint-box">
        <span><span class="method">GET</span><code>/api/products</code></span>
    </div>

    <div class="footer">
        <span>Laravel {{ app()->version() }}</span>
        <span>&copy; Inventory Engine API</span>
    </div>
</div>

</body>
</html>