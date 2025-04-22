@extends('admin.layout.master')
@section('styles')
    <style>
        h4{
            margin-top: 50px;
        }

    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1>@lang('Order Details')</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('main.order_details')</h3>
                </div>

                <div class="card-body">
                    <!-- Order Info -->
                    <h4>@lang('main.user_information')</h4>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>@lang('main.full_name')</th>
                            <td>


                                {{$order->first_name}} {{$order->last_name}}

                            </td>
                        </tr>
                        <tr>
                            <th>@lang('main.email')</th>
                            <td>{{ $order->user ? $order->user->email : 'No Email' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.phone')</th>
                            <td>{{ $order->phone }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>@lang('main.shipments')</h4>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>@lang('main.address')</th>
                            <td>{{ $order->address->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.city')</th>
                            <td>{{ $order->address->city->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.gov')</th>
                            <td>{{ $order->address->gov->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.code')</th>
                            <td>{{ $order->address->postal_code ?? 'N/A' }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Order Items -->
                    <h4>@lang('main.order_items')</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('main.product_name')</th>
                            <th>@lang('main.quantity')</th>
                            <th>@lang('main.per_price')</th>
                            <th>@lang('main.price')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Order Summary -->
                    <h4>@lang('main.order_summary')</h4>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>@lang('main.total_items')</th>
                            <td>{{ $order->items->sum('quantity') }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.total_price')</th>
                            <td>{{ number_format($order->total_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.shiping_price')</th>
                            <td>{{ number_format($order->shipment_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('main.final_total')</th>
                            <td><strong>{{ number_format($order->total_price + $order->shipment_price, 2) }}</strong></td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Payment and Order Status -->

                    <h4>@lang('main.status')</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <span>@lang('main.order_status')</span>
                            <span class="badge badge-{{ $order->status == 'pending' ? 'primary' : ($order->status == 'proceed' ? 'info' : ($order->status == 'on way' ? 'warning' : ($order->status == 'finished' ? 'success' : 'danger'))) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                        </div>


                        <div class="col-md-4">
                            <span>@lang('main.payment_status')</span>
                            <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        </div>

                        <div class="col-md-4">
                            <span>@lang('main.payment_method')</span>
                            <span class="badge badge-{{ $order->payment_method == 'cash' ? 'info' : ($order->payment_method == 'paymob' ? 'warning' : ($order->payment_method == 'paypal' ? 'primary' : 'secondary')) }}">
                            {{ ucfirst($order->payment_method) }}
                        </span>
                        </div>
                    </div>
                    <hr>
                    <!-- Actions -->
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.edit_status', ['id' => $order->id]) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> @lang('main.edit')
                        </a>
                        <a href="{{ route('admin.orders.delete', ['id' => $order->id]) }}" class="btn btn-danger"
                           onclick="return confirm('@lang('Are you sure you want to delete this order?')')">
                            <i class="fas fa-trash"></i> @lang('main.delete')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
