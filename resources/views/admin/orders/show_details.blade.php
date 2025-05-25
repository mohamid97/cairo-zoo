@extends('admin.layout.master')

@section('styles')
<style>
    .info-title {
        font-weight: bold;
        color: #17a2b8;
    }
    .badge-status {
        font-size: 90%;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('main.order_details')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('main.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">@lang('main.orders')</a></li>
                    <li class="breadcrumb-item active">@lang('main.order_details')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">@lang('main.order') #{{ $order->id }}</h3>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <!-- Customer Info -->
                <div class="col-md-6">
                    <h5 class="info-title">@lang('main.customer_info')</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>@lang('main.name'):</strong> {{ $order->first_name }} {{ $order->last_name }}</li>
                        <li class="list-group-item"><strong>@lang('main.phone'):</strong> {{ $order->phone }}</li>
                        <li class="list-group-item">
                            <strong>@lang('main.status'):</strong>
                            <span class="badge badge-status
                                {{ $order->status === 'pending' ? 'badge-primary' :
                                   ($order->status === 'procced' ? 'badge-info' :
                                   ($order->status === 'on-way' ? 'badge-warning' :
                                   ($order->status === 'finished' ? 'badge-success' : 'badge-danger'))) }}">
                                @lang('main.' . $order->status)
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>@lang('main.payment_status'):</strong>
                            <span class="badge badge-status {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                                @lang('main.' . $order->payment_status)
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Order Info -->
                <div class="col-md-6">
                    <h5 class="info-title">@lang('main.order_info')</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>@lang('main.total_before_discount'):</strong> {{ number_format($order->total_price_before_discount, 2) }}</li>
                        <li class="list-group-item"><strong>@lang('main.total_after_discount'):</strong> {{ number_format($order->total_price_after_discount, 2) }}</li>
                        <li class="list-group-item"><strong>@lang('main.shipment_price'):</strong> {{ number_format($order->shipment_price, 2) }}</li>
                        @if ($order->coupon_code)
                        <li class="list-group-item">
                            <strong>@lang('main.coupon'):</strong> {{ $order->coupon_code }}
                            ({{ $order->discount_type === 'percentage' ? '%' : 'EGP' }} {{ $order->coupon_discount }})
                        </li>
                        @endif
                        <li class="list-group-item"><strong>@lang('main.payment_method'):</strong> {{ ucfirst($order->payment_method) }}</li>

                        <li class="list-group-item"><strong>@lang('main.total_order'):</strong> {{ number_format($order->total_price_after_discount + $order->shipment_price , 2)   }}</li>

                    </ul>
                </div>
            </div>

            <hr>

            <!-- Order Items -->
            <h5 class="info-title mb-3">@lang('main.items')</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-info">
                        <tr>
                            <th>@lang('main.product')</th>
                            <th>@lang('main.quantity')</th>
                            <th>@lang('main.sales_price')</th>
                            <th>@lang('main.discount')</th>
                            <th>@lang('main.total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->sales_price, 2) }}</td>
                            <td>{{ number_format($item->discount, 2) }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</section>
@endsection
