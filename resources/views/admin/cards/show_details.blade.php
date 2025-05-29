@extends('admin.layout.master')
@section('styles')
<style>
    .product-img {
        max-width: 80px;
        max-height: 80px;
        object-fit: contain;
    }
</style>
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('main.cart_details')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('main.home')</a></li>
                        <li class="breadcrumb-item active">@lang('main.cart_details')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> @lang('main.details_of'):</h5>
                        {{ $cart->user->first_name . ' ' . $cart->user->last_name }}
                    </div>

                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-user"></i> @lang('main.general_information')
                                    <small class="float-right">@lang('main.date'): {{ $cart->created_at->format('d M Y, H:i') }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <strong>@lang('main.user_information')</strong>
                                <address>
                                    @lang('main.name'): {{ $cart->user->first_name . ' ' . $cart->user->last_name }}<br>
                                    @lang('main.phone'): {{ $cart->user->phone }}<br>
                                    @lang('main.email'): {{ $cart->user->email }}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <strong>@lang('main.cart_details')</strong>
                                <address>
                                  
                                    @lang('main.total_quantity'): {{ $total_quantity }}<br>
                                </address>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('main.product')</th>
                                        <th>@lang('main.quantity')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cart->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                 <div class="d-flex align-items-center">
                                                            @if($item->product && $item->product->image)
                                                            <img src="{{ asset('uploads/images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-img mr-3">
                                                            @endif
                                                            <div>
                                                                <strong>{{ $item->product->name ?? __('main.deleted_product') }}</strong><br>
                                                                <small>{{ $item->product->sku ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>

                                            </td>

                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    </section>

@endsection
