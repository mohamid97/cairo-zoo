@extends('admin.layout.master')

@section('styles')
<style>
    .order-header {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .order-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .badge-lg {
        font-size: 1rem;
        padding: 8px 12px;
    }
    .product-img {
        max-width: 80px;
        max-height: 80px;
        object-fit: contain;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('main.order_details') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cahier_orders.index') }}">{{ __('main.cahier_orders') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('main.order_details') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('main.order_information') }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary badge-lg">
                                {{ __('main.order_id') }}: #{{ $order->id }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row order-header">
                            <div class="col-md-6">
                                <h4><i class="fas fa-user"></i> {{ __('main.cahier_information') }}</h4>
                                <p class="mb-1"><span class="info-label">{{ __('main.name') }}:</span> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                                <p class="mb-1"><span class="info-label">{{ __('main.email') }}:</span> {{ $order->user->email ?? 'N/A' }}</p>
                                <p class="mb-1"><span class="info-label">{{ __('main.phone') }}:</span> {{ $order->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fas fa-receipt"></i> {{ __('main.order_summary') }}</h4>
                                <p class="mb-1"><span class="info-label">{{ __('main.order_date') }}:</span> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                                <p class="mb-1"><span class="info-label">{{ __('main.total_items') }}:</span> {{ $order->items->count() }}</p>
                                <p class="mb-1"><span class="info-label">{{ __('main.total_quantity') }}:</span> {{ $order->items->sum('quantity') }}</p>
                                <p class="mb-1 text-primary"><span class="info-label">{{ __('main.status') }}:</span>  {{ $order->status }}</p>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">{{ __('main.pricing_details') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td><strong>{{ __('main.total_before_discount') }}</strong></td>
                                                <td class="text-right">{{ number_format($order->total_amount_before_discount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ __('main.total_discount') }}</strong></td>
                                                <td class="text-right text-danger">- {{ number_format($order->total_discount, 2) }}</td>
                                            </tr>
                                            @if($order->coupon_code)
                                            <tr>
                                                <td><strong>{{ __('main.coupon_discount') }} ({{ $order->coupon_code }})</strong></td>
                                                <td class="text-right text-danger">- {{ number_format($order->coupon_discount, 2) }}</td>
                                            </tr>
                                            @endif
                                            <tr class="table-success">
                                                <td><strong>{{ __('main.total_after_discount') }}</strong></td>
                                                <td class="text-right"><strong>{{ number_format($order->total_amount_after_discount, 2) }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">{{ __('main.additional_information') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>{{ __('main.payment_method') }}:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                                        <p><strong>{{ __('main.payment_status') }}:</strong> 
                                            <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                {{ $order->payment_status ?? 'N/A' }}
                                            </span>
                                        </p>
                                        <p><strong>{{ __('main.order_status') }}:</strong> 
                                            <span class="badge badge-{{ $order->status == 'completed' ? 'success' : 'primary' }}">
                                                {{ $order->status ?? 'N/A' }}
                                            </span>
                                        </p>
                                        @if($order->notes)
                                        <p><strong>{{ __('main.notes') }}:</strong> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">{{ __('main.order_items') }}</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('main.product') }}</th>
                                                    <th>{{ __('main.price') }}</th>
                                                    <th>{{ __('main.quantity') }}</th>
                                                    <th>{{ __('main.discount') }}</th>
                                                    <th>{{ __('main.total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order_items as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-img mr-3">
                                                            @endif
                                                            <div>
                                                                <strong>{{ $item->product->name ?? __('main.deleted_product') }}</strong><br>
                                                                <small>{{ $item->product->sku ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($item->price_before_discount, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->price_after_discount, 2) }}</td>
                                                    <td>{{ number_format($item->total_price_after_discount, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.cahier_orders.index') }}" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> {{ __('main.back_to_orders') }}
                                </a>
                                <button class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print"></i> {{ __('main.print_invoice') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection