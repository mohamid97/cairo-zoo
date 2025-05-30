<!DOCTYPE html>
<html>
<head>
    <title>{{ __('main.monthly_statistics') }} - {{ $date->format('F Y') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin-bottom: 5px; font-size: 18px; }
        .header h2 { margin-top: 0; font-size: 16px; color: #555; }
        .header p { margin-top: 5px; color: #777; font-size: 12px; }
        .section-title { 
            background-color: #f5f5f5; 
            padding: 5px 8px;
            margin: 15px 0 8px 0;
            font-weight: bold;
            border-left: 4px solid #666;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px;
            font-size: 12px;
        }
        th, td { 
            padding: 6px 8px; 
            border: 1px solid #ddd; 
            text-align: left;
        }
        th { 
            background-color: #f9f9f9; 
            font-weight: bold;
        }
        .total-row { 
            font-weight: bold; 
            background-color: #f8f9fa; 
        }
        .profit-row { 
            font-weight: bold; 
            color: #28a745;
        }
        .currency {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <h2>{{ __('main.monthly_statistics') }} - {{ $date->format('F Y') }}</h2>
        <p>{{ __('main.generated_on') }}: {{ now()->format('Y-m-d H:i') }}</p>
    </div>

    <div class="section-title">{{ __('main.online_orders') }}</div>
    <table>
        <tr>
            <td width="70%">{{ __('main.revenu') }}</td>
            <td class="currency">{{ number_format($online['revenue'], 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr>
            <td>{{ __('main.shipment_revenu') }}</td>
            <td class="currency">{{ number_format($online['shipment'], 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr>
            <td>{{ __('main.cost') }}</td>
            <td class="currency">{{ number_format($online['cost'], 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr class="profit-row">
            <td>{{ __('main.gross_profit') }}</td>
            <td class="currency">{{ number_format($online['profit'], 2) }} {{ __('main.egp') }}</td>
        </tr>
    </table>

    <div class="section-title">{{ __('main.cashier_orders') }}</div>
    <table>
        <tr>
            <td width="70%">{{ __('main.revenu') }}</td>
            <td class="currency">{{ number_format($cashier['revenue'], 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr>
            <td>{{ __('main.cost') }}</td>
            <td class="currency">{{ number_format($cashier['cost'], 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr class="profit-row">
            <td>{{ __('main.gross_profit') }}</td>
            <td class="currency">{{ number_format($cashier['profit'], 2) }} {{ __('main.egp') }}</td>
        </tr>
    </table>

    <div class="section-title">{{ __('main.summary') }}</div>
    <table>
        <tr class="total-row">
            <td width="70%">{{ __('main.total_profit') }}</td>
            <td class="currency">{{ number_format($cashier['profit'] + $online['profit'] , 2) }} {{__('main.egp')}}</td>
        </tr>
        <tr class="total-row">
            <td width="70%">{{ __('main.shipment_revenu') }}</td>
            <td class="currency">{{ number_format($online['shipment'], 2) }} {{__('main.egp')}}</td>
        </tr>




        <tr>
            <td>{{ __('main.variable_expenses') }}</td>
            <td class="currency">{{ number_format($total_variable_expenses, 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr>
            <td>{{ __('main.fixed_expenses') }}</td>
            <td class="currency">{{ number_format($total_fixed_expenses, 2) }} {{ __('main.egp') }}</td>
        </tr>
        <tr class="profit-row">
            <td>{{ __('main.net_profit') }}</td>
            <td class="currency">{{ number_format($net_profit, 2) }} {{ __('main.egp') }}</td>
        </tr>
    </table>
</body>
</html>