@extends('admin.layout.master')

@section('styles')
@parent
<style>
    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-container, .print-container * {
            visibility: visible;
        }
        .print-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-header h2 {
            margin-bottom: 5px;
            color: #333;
        }
        .print-header h3 {
            margin-top: 0;
            color: #555;
        }
        .print-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .print-table th, .print-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .print-table th {
            background-color: #f5f5f5;
            text-align: left;
        }
        .print-total {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .print-profit {
            font-weight: bold;
            color: #28a745;
        }
        @page {
            size: A4 portrait;
            margin: 1cm;
        }
    }
    
    /* Screen-specific styles */
    @media screen {
        .print-header {
            display: none;
        }
    }
</style>
@endsection

@section('content')

<section class="content-header no-print">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{__('main.monthly_statistics')}} {{ $date->format('F Y') }}</h3>
                <form method="GET" class="form-inline" action="{{ route('admin.statistics.monthly_report') }}">
                    <div class="input-group input-group-sm">
                        <input type="month" class="form-control" name="date" 
                               value="{{ $date->format('Y-m') }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-search"></i> {{__('main.filter')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid print-container">
        <!-- Print Header (only visible when printing) -->
        <div class="print-header">
            <h2>{{ config('app.name') }}</h2>
            <h3>{{__('main.monthly_statistics')}} - {{ $date->format('F Y') }}</h3>
            <p>{{__('main.printed_at')}}: {{ now()->format('Y-m-d H:i') }}</p>
        </div>

        <div class="row mb-4 print-section">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-header">
                        <h4 class="card-title">{{__('main.online_orders')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm print-table">
                            <tr>
                                <td>{{__('main.revenu')}}</td>
                                <td class="text-right">{{ number_format($online['revenue'], 2) }} {{__('main.egp')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('main.shipment_revenu')}}</td>
                                <td class="text-right">{{ number_format($online['shipment'], 2) }} {{__('main.egp')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('main.cost')}}</td>
                                <td class="text-right">{{ number_format($online['cost'], 2) }} {{__('main.egp')}}</td>
                            </tr>
                            <tr class="table-success print-profit">
                                <td><strong>{{__('main.gross_profit')}}</strong></td>
                                <td class="text-right"><strong>{{ number_format($online['profit'], 2) }} {{__('main.egp')}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-header">
                        <h4 class="card-title">{{__('main.cashier_orders')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm print-table">
                            <tr>
                                <td>{{__('main.revenu')}}</td>
                                <td class="text-right">{{ number_format($cashier['revenue'], 2) }} {{__('main.egp')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('main.cost')}}</td>
                                <td class="text-right">{{ number_format($cashier['cost'], 2) }} {{__('main.egp')}}</td>
                            </tr>
                            <tr class="table-success print-profit">
                                <td><strong>{{__('main.gross_profit')}}</strong></td>
                                <td class="text-right"><strong>{{ number_format($cashier['profit'], 2) }} {{__('main.egp')}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card print-section">
            <div class="card-header">
                <h4 class="card-title">{{__('main.summary')}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered print-table">
                    <tr class="table-info print-total">
                        <td><strong>{{__('main.total_profit')}}</strong></td>
                        <td class="text-right"><strong>{{ number_format($cashier['profit'] + $online['profit'] , 2) }} {{__('main.egp')}}</strong></td>
                    </tr>

                    <tr class="table-info print-total">
                        <td><strong>{{__('main.shipment_revenu')}}</strong></td>
                        <td class="text-right"><strong>{{ number_format($online['shipment'], 2) }} {{__('main.egp')}}</strong></td>
                    </tr>

                    <tr class="table-danger print-total">
                        <td>{{__('main.variable_expenses')}}</td>
                        <td class="text-right">{{ number_format($total_variable_expenses, 2) }} {{__('main.egp')}}</td>
                    </tr>
                    <tr class="table-danger print-total">
                        <td>{{__('main.fixed_expenses')}}</td>
                        <td class="text-right">{{ number_format($total_fixed_expenses, 2) }} {{__('main.egp')}}</td>
                    </tr>
                    <tr class="table-success print-profit">
                        <td><strong>{{__('main.net_profit')}}</strong></td>
                        <td class="text-right"><strong>{{ number_format($net_profit, 2) }} {{__('main.egp')}}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4 text-center no-print">
            <button class="btn btn-success" id="print-report">
                <i class="fas fa-print"></i> {{__('main.print_report')}}
            </button>
            <a href="{{ route('admin.statistics.export', ['type' => 'pdf', 'date' => $date->format('Y-m-d')]) }}" 
               class="btn btn-danger" id="download-pdf">
                <i class="fas fa-file-pdf"></i> {{__('main.download_pdf')}}
            </a>
            <a href="{{ route('admin.statistics.export', ['type' => 'excel', 'date' => $date->format('Y-m-d')]) }}" 
               class="btn btn-success" id="download-excel">
                <i class="fas fa-file-excel"></i> {{__('main.export_excel')}}
            </a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced print functionality
    document.getElementById('print-report').addEventListener('click', function() {
        // Before printing actions
        const originalTitle = document.title;
        document.title = "{{__('main.monthly_statistics')}} - {{ $date->format('F Y') }} - {{ config('app.name') }}";
        
        // Add print-specific class to body for better print control
        document.body.classList.add('printing');
        
        // Print the document
        window.print();
        
        // After printing cleanup
        setTimeout(function() {
            document.title = originalTitle;
            document.body.classList.remove('printing');
        }, 500);
    });
    
    // Show print dialog when URL has ?print=true
    if (window.location.search.includes('print=true')) {
        document.getElementById('print-report').click();
    }

    // PDF download tracking
    document.getElementById('download-pdf').addEventListener('click', function() {
        // You can add analytics tracking here
        console.log('PDF download initiated');
    });

    // Excel download tracking
    document.getElementById('download-excel').addEventListener('click', function() {
        // You can add analytics tracking here
        console.log('Excel download initiated');
    });
});
</script>
@endsection