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
                    <h1>{{ __('main.coupons') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.coupons') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.coupons.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_coupon') }}
                    </button>
                </a>
            </div>
            <br>

            <div class="row mb-3">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('admin.coupons.index') }}" class="form-inline gap-2">
                        <input type="text" name="search" value="{{ $searchTerm }}" class="form-control mr-2" placeholder="{{ __('main.search_by_code') }}">

                        <select name="status" class="form-control mr-2">
                            <option value="">{{ __('main.all') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('main.active') }}</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('main.expired') }}</option>
                        </select>

                        <input type="date" name="start_from" value="{{ $startFrom }}" class="form-control mr-2" placeholder="{{ __('main.start_from') }}">
                        <input type="date" name="end_to" value="{{ $endTo }}" class="form-control mr-2" placeholder="{{ __('main.end_to') }}">

                        <button class="btn btn-info" type="submit">
                            <i class="fas fa-search"></i> {{ __('main.search') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.coupons') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.code') }}</th>
                            <th>{{ __('main.type') }}</th>
                            <th>{{ __('main.value') }}</th>
                            <th>{{ __('main.start_date') }}</th>
                            <th>{{ __('main.end_date') }}</th>
                            <th>{{ __('main.usage') }}</th>
                            <th>{{ __('main.status') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($coupons as $index => $coupon)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ ucfirst($coupon->type) }}</td>
                                <td>{{ $coupon->discount_value }}</td>
                                <td>{{ $coupon->start_date ?? '-' }}</td>
                                <td>{{ $coupon->end_date ?? '-' }}</td>
                                <td>{{ $coupon->times_used }} / {{ $coupon->usage_limit ?? __('main.unlimited') }}</td>
                                <td>
                                    @if(!$coupon->is_active || ($coupon->end_date && $coupon->end_date < now()))
                                        <span class="badge badge-danger">{{ __('main.expired') }}</span>
                                    @else
                                        <span class="badge badge-success">{{ __('main.active') }}</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i></button>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="showDeleteCouponModal({{ $coupon->id }})">
                                        <i class="nav-icon fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9">{{ __('main.no_data') }}</td></tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteCouponModal" tabindex="-1" role="dialog" aria-labelledby="confirmCouponDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmCouponDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_Coupon_warning') ?? 'Are you sure you want to delete this Coupon? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteCouponBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('scripts')
    <script>
        function showDeleteCouponModal(couponId) {
            const url = `{{ url('admin/coupons/delete') }}/${couponId}`;
            document.getElementById('confirmDeleteCouponBtn').setAttribute('href', url);
            $('#confirmDeleteCouponModal').modal('show');
        }
    </script>
@endsection



