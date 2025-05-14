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
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('main.brands') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('main.cahier_orders') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">


        {{--            <div class="row mb-3">--}}
        {{--                <div class="col-md-6">--}}
        {{--                    <form method="GET" action="{{ route('admin.brands.index') }}" class="input-group">--}}
        {{--                        <input type="text" name="search" value="{{ $searchTerm }}" class="form-control"
        placeholder="{{ __('main.search_by_name') }}">--}}
        {{--                        <div class="input-group-append">--}}
        {{--                            <button class="btn btn-info" type="submit">--}}
        {{--                                <i class="fas fa-search"></i> {{ __('main.search') }}--}}
        {{--                            </button>--}}
        {{--                        </div>--}}
        {{--                    </form>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('main.cahier_orders') }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.cahier_name') }}</th>
                            <th>{{ __('main.total_order_amount_before_discount') }}</th>
                            <th>{{ __('main.total_order_amount_after_discount') }}</th>
                            <th>{{ __('main.total_discount') }}</th>
                            <th>{{ __('main.has_coupon') }}</th>
                            <th>{{ __('main.num_propducts') }}</th>
                            <th>{{ __('main.quantity_products') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cahier_orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{$order->user->first_name }} {{   $order->user->last_name }}
                            </td>
                            <td> <span class="badge badge-success">{{ $order->total_amount_before_discount }}</span>
                            </td>
                            <td> <span class="badge badge-success"> {{ $order->total_amount_after_discount }} </span>
                            </td>
                            <td> <span class="badge badge-success"> {{ $order->total_discount }} </span> </td>
                            <td>

                                <span class="d-flex align-items-center gap-2">
                                    @if($order->coupon_code)
                                    <span class="badge badge-success">{{$order->coupon_code}}</span>
                                    @else
                                    <span class="badge badge-danger">{{ __('main.no_coupon') }}</span>
                                    @endif



                                    @if($order->coupon_code > 0)
                                    <span class="badge badge-success">{{$order->coupon_discount}}</span>
                                    @else
                                    <span class="badge badge-danger">{{ __('main.no_coupon_discount') }}</span>
                                    @endif
                                </span>




                            </td>

                            <td>{{$order->items->count()}} </td>
                            <td>

                                {{$order->items->sum('quantity')}}
                            </td>


                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">


                                    <a href="{{ route('admin.cahier_orders.show', ['id' => $order->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-eye"></i>
                                        </button>
                                    </a>

                                    <!-- Delete With Confirmation -->
{{--                                    <button class="btn btn-sm btn-danger"--}}
{{--                                        onclick="showDeleteBrandModal({{ $brand->id }})">--}}
{{--                                        <i class="nav-icon fas fa-trash"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">{{ __('main.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center" style="margin-top: 50px;">
                    {{ $cahier_orders->links() }}
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
