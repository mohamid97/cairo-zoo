@extends('admin.layout.master')

@section('styles')
<style>
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
                <h1>{{ __('main.diffs') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('main.diffs') }}</li>
                </ol>
            </div>
        </div>
    </div>


    
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.cahier_orders.diff') }}" class="form-inline mb-4">
    <div class="form-group mr-2">
        <label for="start_date" class="mr-2">{{ __('main.start_date') }}</label>
        <input type="date" id="start_date" name="start_date" class="form-control"
               value="{{ request('start_date') }}">
    </div>

    <div class="form-group mr-2">
        <label for="end_date" class="mr-2">{{ __('main.end_date') }}</label>
        <input type="date" id="end_date" name="end_date" class="form-control"
               value="{{ request('end_date') }}">
    </div>

    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> {{ __('main.search') }}</button>
   <a href="{{ route('admin.cahier_orders.diff') }}" class="btn btn-primary ml-2">
    <i class="fas fa-sync-alt mr-1"></i> {{ __('main.reset') }}
</a>

</form>


                </div>
            </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('main.diffs') }}</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('main.product') }}</th>
                            <th>{{ __('main.total_difference') }}</th>
                            <th>{{ __('main.total_quantity') }}</th>
                            <th>{{ __('main.show_details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grouped = $diffs->groupBy('product_id');
                        @endphp

                        @foreach($grouped as $product_id => $diffGroup)
                            @php
                                $product = $diffGroup->first()->product;
                                $totalAmount = $diffGroup->sum('amount');
                                $totalQty = $diffGroup->sum('quantity');
                                $collapseId = 'collapse_' . $product_id;
                            @endphp

                            <tr class="cursor-pointer" data-toggle="collapse" data-target="#{{ $collapseId }}">
                                <td>{{ $product->name ?? '-' }}</td>
                                <td>{{ number_format($totalAmount, 2) }}</td>
                                <td>{{ $totalQty }}</td>
                                <td><i class="fas fa-chevron-down"></i></td>
                            </tr>

                            <tr class="collapse bg-light" id="{{ $collapseId }}">
                                <td colspan="4">
                                    <table class="table mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th>{{ __('main.quantity') }}</th>
                                                <th>{{ __('main.amount') }}</th>
                                                <th>{{ __('main.diff_amount') }}</th>
                                                <th>{{ __('main.date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($diffGroup as $diff)
                                                <tr>
                                                    <td>{{ $diff->quantity }}</td>
                                                    <td>{{ number_format($diff->amount, 2) }}</td>
                                                    <td>{{ number_format($diff->diff_amount, 2) }}</td>
                                                    <td>{{ $diff->created_at->format('Y-m-d') }}</td>
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
                    {{ $diffs->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
