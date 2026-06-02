```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Warehouse Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            color: #666;
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .summary {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary td {
            width: 33%;
            border: 1px solid #ddd;
            text-align: center;
            padding: 12px;
        }

        .summary-title {
            font-size: 11px;
            color: #666;
        }

        .summary-value {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        h3 {
            background: #f4f4f4;
            padding: 8px;
            border-left: 4px solid #555;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th {
            background: #444;
            color: #fff;
            padding: 8px;
            text-align: left;
        }

        table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .expiring {
            background-color: #ffe5e5;
        }

        .danger {
            color: #c0392b;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Inventory Management System</div>
    <div class="subtitle">Warehouse Stock Report</div>
</div>

<table class="info-table">
    <tr>
        <td><strong>Warehouse:</strong> {{ $warehouse->name }}</td>
        <td><strong>Location:</strong> {{ $warehouse->location }}</td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>Generated At:</strong>
            {{ now()->format('d M Y h:i A') }}
        </td>
    </tr>
</table>

<table class="summary">
    <tr>
        <td>
            <div class="summary-title">Total Products</div>
            <div class="summary-value">{{ $products->count() }}</div>
        </td>

        <td>
            <div class="summary-title">Total Quantity</div>
            <div class="summary-value">{{ $products->sum('quantity') }}</div>
        </td>

        <td>
            <div class="summary-title">Near Expiring</div>
            <div class="summary-value">{{ $nearExpiring->count() }}</div>
        </td>
    </tr>
</table>

<h3>Product Inventory</h3>

<table class="data-table">
    <thead>
        <tr>
            <th>SKU</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Base Price</th>
            <th>Selling Price</th>
            <th>Expiry Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)

            @php
                $isExpiring =
                    !empty($product['expires_at']) &&
                    \Carbon\Carbon::parse($product['expires_at'])
                        ->between(now(), now()->addDays(7));
            @endphp

            <tr class="{{ $isExpiring ? 'expiring' : '' }}">
                <td>{{ $product['sku'] }}</td>
                <td>{{ $product['product_name'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>${{ number_format($product['base_price'], 2) }}</td>
                <td>${{ number_format($product['dynamic_selling_price'], 2) }}</td>
                <td>
                    @if($product['expires_at'])
                        {{ $product['expires_at'] }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

@if($nearExpiring->count())
    <h3>⚠ Near Expiring Products (Next 7 Days)</h3>

    <table class="data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Expiry Date</th>
                <th>Days Left</th>
            </tr>
        </thead>

        <tbody>
            @foreach($nearExpiring as $item)
                <tr class="expiring">
                    <td>{{ $item['sku'] }}</td>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['expires_at'] }}</td>
                    <td class="danger">
                        {{ $item['days_left'] }} days
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<div class="footer">
    Inventory Management System • Warehouse Report
</div>

</body>
</html>

