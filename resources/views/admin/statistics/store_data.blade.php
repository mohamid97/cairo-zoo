@extends('admin.layout.master')

@section('styles')
    <style>
        svg {
            font-size: 5px;
            width: 28px;
        }
        .text-sm {
            margin-top: 26px;
            font-size: .875rem !important;
        }
        .gap-2 {
            gap: 10px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.store_data') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.store_data') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-4">
                    <!-- product Filter -->
                    <form method="GET" action="{{ route('admin.statistics.store') }}">
                        <div class="form-group">
                            <select name="product_id" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ __('main.filter_by_product') }}</option>
                                @foreach($all_products as $product)
                                    <option value="{{ $product->id }}" {{ $selectedProduct == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-info">


                <div class="card-header">
                    <h3 class="card-title">{{ __('main.store_data') }}</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('main.product') }}</th>
                            <th>{{ __('main.stock') }}</th>
                            <th>{{ __('main.total_sales_cost') }}</th>
                            <th>{{ __('main.total_cost') }}</th>
                            <th>{{ __('main.show_details') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            @php
                                $collapseId = 'collapse_' . $product->id;
                                $total_cost = $product->stocks->sum(fn($s) => $s->quantity * $s->cost_price);
                                $stock_movements = $product->stocks->map(fn($s) => [
                                    'quantity' => $s->quantity,
                                    'cost_price' => $s->cost_price,
                                    'created_at' => $s->created_at->format('Y-m-d H:i:s'),
                                ]);
                            @endphp

                            <tr class="cursor-pointer" data-toggle="collapse" data-target="#{{ $collapseId }}">
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ number_format($product->sales_price * $product->stock, 2) }}</td>
                                <td>{{ number_format($total_cost, 2) }}</td>
                                <td><i class="fas fa-chevron-down"></i></td>
                            </tr>

                            <tr class="collapse bg-light" id="{{ $collapseId }}">
                                <td colspan="5">
                                    <table class="table mb-0 table-sm">
                                        <thead>
                                        <tr>
                                            <th>{{ __('main.quantity') }}</th>
                                            <th>{{ __('main.cost_price') }}</th>
                                            <th>{{ __('main.total') }}</th>
                                            <th>{{ __('main.date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($stock_movements as $movement)
                                            <tr>
                                                <td>{{ $movement['quantity'] }}</td>
                                                <td>{{ number_format($movement['cost_price'], 2) }}</td>
                                                <td>{{ number_format($movement['quantity'] * $movement['cost_price'], 2) }}</td>
                                                <td>{{ $movement['created_at'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
