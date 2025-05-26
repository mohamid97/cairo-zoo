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
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('main.all_orders')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('main.home')</a></li>
                        <li class="breadcrumb-item active">@lang('main.orders')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('main.all_orders')</h3>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <input type="text" name="product" class="form-control" value="{{ request()->product }}" placeholder="@lang('main.search_by_product')">
                            </div>

                            <div class="col-md-2">
                                <input type="text" name="user" class="form-control" value="{{ request()->user }}" placeholder="@lang('main.search_by_user')">
                            </div>

                            <div class="col-md-2">
                                <input type="date" name="from_date" class="form-control" value="{{ request()->from_date }}" placeholder="@lang('main.from_date')">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="to_date" class="form-control" value="{{ request()->to_date }}" placeholder="@lang('main.to_date')">
                            </div>

                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">@lang('main.all_status')</option>
                                    <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>@lang('main.pending')</option>
                                    <option value="procced" {{ request()->status == 'procced' ? 'selected' : '' }}>@lang('main.proceed')</option>
                                    <option value="on-way" {{ request()->status == 'on-way' ? 'selected' : '' }}>@lang('main.on_way')</option>
                                    <option value="finished" {{ request()->status == 'finished' ? 'selected' : '' }}>@lang('main.finished')</option>
                                    <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>@lang('main.canceled')</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <select name="sort" class="form-control">
                                    <option value="desc" {{ request()->sort == 'desc' ? 'selected' : '' }}>@lang('main.descending')</option>
                                    <option value="asc" {{ request()->sort == 'asc' ? 'selected' : '' }}>@lang('main.ascending')</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search nav-icon"></i> @lang('main.search')</button>
                            </div>
                        </div>
                    </form>

                    <!-- Orders Table -->
                    <div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>@lang('main.customer_name')</th>
            <th>@lang('main.phone')</th>
            <th>@lang('main.total_before_discount')</th>
            <th>@lang('main.total_after_discount')</th>
            <th>@lang('main.status')</th>
            <th>@lang('main.coupon')</th>
            <th>@lang('main.payment_status')</th>
            <th>@lang('main.action')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $index => $order)
            <tr data-toggle="collapse" data-target="#items-{{ $order->id }}" class="accordion-toggle" style="cursor: pointer">
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                <td>{{ $order->phone }} </td>

                <td>{{ number_format($order->total_price_before_discount, 2) }}</td>
                <td>{{ number_format($order->total_price_after_discount, 2) }}</td>
                <td>
                    @if ($order->status == 'pending')
                        <span class="badge badge-primary">@lang('main.pending')</span>
                    @elseif ($order->status == 'procced')
                        <span class="badge badge-info">@lang('main.proceed')</span>
                    @elseif ($order->status == 'on-way')
                        <span class="badge badge-warning">@lang('main.on_way')</span>
                    @elseif ($order->status == 'finshed')
                        <span class="badge badge-success">@lang('main.finished')</span>
                    @elseif ($order->status == 'canceled')
                        <span class="badge badge-danger">@lang('main.canceled')</span>

                    @elseif ($order->status == 'retrieval')
                        <span class="badge badge-danger">@lang('main.retrieval')</span>
                    @endif
                </td>
                <td>{{ $order->coupon_code ?? '-' }}</td>
                <td>
                    @if ($order->payment_status == 'paid')
                        <span class="badge badge-success">@lang('main.paid')</span>
                    @else
                        <span class="badge badge-danger">@lang('main.unpaid')</span>
                    @endif
                </td>
                <td class="d-flex" style="gap: 5px">
{{--                    <a href="{{ route('admin.orders.delete', $order->id) }}" class="btn btn-sm btn-danger" title="@lang('main.remove')">--}}
{{--                        <i class="fas fa-trash"></i>--}}
{{--                    </a>--}}
                    <a href="{{ route('admin.orders.show_details', $order->id) }}" class="btn btn-sm btn-primary" title="@lang('main.show')">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.orders.edit_status', $order->id) }}" class="btn btn-sm btn-primary" title="@lang('main.edit_status')">
                        <i class="fas fa-edit"></i>
                    </a>


                    <a href="{{ route('admin.orders.retrieval', $order->id) }}" class="btn btn-sm btn-primary" title="@lang('main.retrieval')">
                        <i class="fas fa-undo"></i>

                    </a>


                </td>
            </tr>

            <!-- Collapsible row -->
            <tr>
                <td colspan="9" class="hiddenRow">
                    <div class="collapse" id="items-{{ $order->id }}">
                        <table class="table table-sm table-bordered" style="background: #17a2b8;
    color: #FFF;">
                            <thead>
                                <tr>
                                    <th>@lang('main.product')</th>
                                    <th>@lang('main.quantity')</th>
                                    <th>@lang('main.sales_price')</th>
                                    <th>@lang('main.discount')</th>
                                    <th>@lang('main.price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->sales_price }}</td>
                                        <td>{{ $item->discount }}</td>
                                        <td>{{$item->price}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">@lang('main.no_data')</td>
            </tr>
        @endforelse
    </tbody>
</table>

                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $orders->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
