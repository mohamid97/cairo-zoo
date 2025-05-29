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
            <!-- Existing header content here -->
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('main.all_carts')</h3>
                </div>

                <div class="card-body">
                    <!-- Filter form -->
                    <form method="GET" action="{{ route('admin.cards.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="first_name" value="{{ request('first_name') }}" class="form-control" placeholder="@lang('main.first_name')">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="last_name" value="{{ request('last_name') }}" class="form-control" placeholder="@lang('main.last_name')">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="product_name" value="{{ request('product_name') }}" class="form-control" placeholder="@lang('main.product_name')">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> {{ __('main.search') }}</button>
                                                    <a href="{{ route('admin.cards.index') }}" class="btn btn-primary ml-2">
                     <i class="fas fa-sync-alt mr-1"></i> {{ __('main.reset') }}
                 </a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('main.first_name')</th>
                            <th>@lang('main.last_name')</th>
                            <th>@lang('main.quantity')</th>
                            <th>@lang('main.items')</th>
                            <th>@lang('main.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($carts as $index => $cart)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cart->user->first_name }}</td>
                                <td>{{ $cart->user->last_name }}</td>
                                <td>{{ $cart->items->sum('quantity') }}</td>
                                <td>
                                    <ul>
                                        @foreach($cart->items as $item)
                                            <li>{{ $item->product->name }} ({{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('admin.cards.delete', ['id' => $cart->id]) }}">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="nav-icon fas fa-trash"></i> 
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.cards.show_details', ['id' => $cart->id]) }}">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="nav-icon fas fa-eye"></i> 
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">@lang('main.no_data')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $carts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
