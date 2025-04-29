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
                    <h1>{{ __('main.discounts') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.discounts') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.discounts.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_discount') }}
                    </button>
                </a>
            </div>
            <br>



            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.discounts') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.type') }}</th>
                            <th>{{ __('main.value') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($discounts as $index => $discount)
                            <tr>
                                <td>{{$index + 1 }}</td>
                                <td>
                                    @switch($discount->type)
                                        @case('product')
                                        {{ $discount->product?->name ?? '-' }}
                                        @break
                                        @case('brand')
                                        {{ $discount->brand?->name ?? '-' }}
                                        @break
                                        @case('category')
                                        {{ $discount->category?->name ?? '-' }}
                                        @break
                                        @default
                                        {{ __('main.global') }}
                                    @endswitch
                                </td>
                                <td>{{ ucfirst($discount->type) }}</td>
                                <td>
                                    @if ($discount->percentage == 'YES')
                                        {{ $discount->discount_percentage }}%
                                    @else
                                        {{ $discount->discount_amount }}
                                    @endif
                                </td>
                                <td class="d-flex align-items-center justify-content-center gap-2">
{{--                                    <a href="{{ route('admin.brands.edit', ['id' => $brand->id]) }}">--}}
{{--                                        <button class="btn btn-sm btn-info">--}}
{{--                                            <i class="nav-icon fas fa-edit"></i>--}}
{{--                                        </button>--}}
{{--                                    </a>--}}

                                    <!-- Delete With Confirmation -->
                                    <button class="btn btn-sm btn-danger" onclick="showDeleteDiscountModal({{ $discount->id }})">
                                        <i class="nav-icon fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteDiscountModal" tabindex="-1" role="dialog" aria-labelledby="confirmDiscountDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDiscountDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_discount_warning') ?? 'Are you sure you want to delete this Discount? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteDiscountBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showDeleteDiscountModal(discountId) {
            const url = `{{ url('admin/discounts/delete') }}/${discountId}`;
            document.getElementById('confirmDeleteDiscountBtn').setAttribute('href', url);
            $('#confirmDeleteDiscountModal').modal('show');
        }
    </script>
@endsection
