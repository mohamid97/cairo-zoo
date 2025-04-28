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
        .gap-2{
            gap: 10px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.stocks') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('main.products') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.stocks') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ $product->name  }} | {{ $product->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.quantity') }}</th>
                            <th>{{ __('main.cost_price') }}</th>
                            <th>{{ __('main.sales_price') }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($product->stocks as $index => $stock)
                            <tr>
                                <td>{{ 1 + $index }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ $stock->cost_price }}</td>
                                <td>{{ $stock->sales_price }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
{{--                    <div class="d-flex justify-content-center" style="margin-top: 50px;">--}}
{{--                        <!-- Pagination Links -->--}}
{{--                        {{ $products->links() }}--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </section>



@endsection

