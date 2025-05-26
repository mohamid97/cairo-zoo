<!DOCTYPE html>
<html>
<head>
    <title>Monthly Statistics Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
<h2>Monthly Statistics Report ({{ \Carbon\Carbon::parse($data['date'])->format('F Y') }})</h2>

<table>
    <tr>
        <th>Category</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>Online Orders Revenue</td>
        <td>{{ number_format($data['online_orders']->completed_revenue ?? 0, 2) }}</td>
    </tr>
    <tr>
        <td>Online Orders Shipment</td>
        <td>{{ number_format($data['online_orders']->total_shipment_complete ?? 0, 2) }}</td>
    </tr>
    <tr>
        <td>Cashier Orders Revenue</td>
        <td>{{ number_format($data['cashier_orders']->completed_revenue ?? 0, 2) }}</td>
    </tr>
    <tr>
        <td>Total Revenue</td>
        <td>{{ number_format($data['total_revenue'], 2) }}</td>
    </tr>
    <tr>
        <td>Total Variable Expenses</td>
        <td>{{ number_format($data['total_variable_expenses'], 2) }}</td>
    </tr>
    <tr>
        <td>Total Fixed Expenses</td>
        <td>{{ number_format($data['total_fixed_expenses'], 2) }}</td>
    </tr>
</table>
</body>
</html>
