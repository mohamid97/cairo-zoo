@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Monthly Statistics</h3>
                <form method="GET" class="form-inline" action="{{ route('admin.statistics.monthly_report') }}">
                    <div class="input-group input-group-sm">
                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d', strtotime($date)) }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm ml-2">Filter</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Metric</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Online Order Revenue</td>
                            <td>{{ number_format($online_orders->completed_revenue ?? 0, 2) }} EGP</td>
                        </tr>
                        <tr>
                            <td>Online Shipment Revenue</td>
                            <td>{{ number_format($online_orders->total_shipment_complete ?? 0, 2) }} EGP</td>
                        </tr>
                        <tr>
                            <td>Cashier Order Revenue</td>
                            <td>{{ number_format($cashier_orders->completed_revenue ?? 0, 2) }} EGP</td>
                        </tr>
                        <tr>
                            <td><strong>Total Revenue</strong></td>
                            <td><strong>{{ number_format($combined_stats['total_revenue'] ?? 0, 2) }} EGP</strong></td>
                        </tr>
                        <tr>
                            <td>Variable Expenses</td>
                            <td>{{ number_format($total_variable_expenses ?? 0, 2) }} EGP</td>
                        </tr>
                        <tr>
                            <td>Fixed Expenses</td>
                            <td>{{ number_format($total_fixed_expenses ?? 0, 2) }} EGP</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <button class="btn btn-success" onclick="window.print()">🖨 Print</button>
                    <a href="{{ route('admin.statistics.export', ['type' => 'pdf', 'date' => $date]) }}" class="btn btn-danger">📄 Download PDF</a>
                    <a href="{{ route('admin.statistics.export', ['type' => 'excel', 'date' => $date]) }}" class="btn btn-success">📊 Export Excel</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
