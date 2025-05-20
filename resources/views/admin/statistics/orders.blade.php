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
                    <h1>{{ __('main.orders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.orders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">



            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.orders') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.total_price_after_discount') }}</th>
                            <th>{{ __('main.total_price_before_discount') }}</th>
                            <th>{{ __('main.total_price_after_discount') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection


