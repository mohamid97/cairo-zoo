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
                    <h1>{{ __('main.products') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.products') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.products.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_product') }}
                    </button>
                </a>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-4">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.products.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_by_name') }}">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">
                                <i class="fas fa-search"></i> {{ __('main.search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <!-- Category Filter -->
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="form-group">
                            <select name="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ __('main.filter_by_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <!-- Brand Filter -->
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="form-group">
                            <select name="brand_id" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ __('main.filter_by_brand') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $selectedBrand == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>





            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_products') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.image') }}</th>
                            <th>{{ __('main.thumbinal') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.category') }}</th>
                            <th>{{ __('main.brand') }}</th>
                            <th>{{ __('main.sales_price')}}</th>
                            <th>{{ __('main.sku') }}</th>
                            <th>{{ __('main.stock') }}</th>

                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $index => $pro)
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>

                                <td>
                                    <a target="_blank" href="{{ asset('uploads/images/products/' . $pro->image) }}">
                                        <img class="img-circle" src="{{ asset('uploads/images/products/' . $pro->image) }}" width="40px" height="40px" alt="{{ __('main.product_image') }}">

                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ asset('uploads/images/products/' . $pro->thumbinal) }}">
                                        <img class="img-circle" src="{{ asset('uploads/images/products/' . $pro->thumbinal) }}" width="40px" height="40px" alt="{{ __('main.product_image') }}">

                                    </a>
                                </td>
                                <td>{{ $pro->name }}</td>
                                <td>
                                    @forelse($categories as $cat)
                                        @if($cat->id == $pro->category_id)
                                            <span class="badge badge-danger">{{ $cat->name }}</span>
                                        @endif
                                    @empty
                                    @endforelse
                                </td>
                                <td>{{ ($pro->brand) ? $pro->brand->name  : 'N/A' }}</td>
                                <td>{{ $pro->sales_price }}</td>
                                <td>{{ $pro->sku }}</td>
                                <td>{{ $pro->stock }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.products.edit', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i></button>
                                        </a>
                                        {{-- <a href="{{ route('admin.products.files', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-success"><i class="fas fa-file"></i></button>
                                        </a>

                                        <a href="{{ route('admin.products.props', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-success"><i class="fas fa-cog"></i>
                                            </button>
                                        </a> --}}


                                        <a href="{{ route('admin.products.show_stock_movement', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </a>


                                        <a href="{{ route('admin.products.gallery', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-images"></i>
                                            </button>
                                        </a>




                                        <button class="btn btn-sm btn-danger" onclick="showDeleteProductModal({{ $pro->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>
                                    </div>



{{--                                    @if($pro->deleted_at == null)--}}
{{--                                        <a href="{{ route('admin.products.soft_delete', ['id' => $pro->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i></button>--}}
{{--                                        </a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{ route('admin.products.restore', ['id' => $pro->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> </button>--}}
{{--                                        </a>--}}
{{--                                    @endif--}}




{{--                                    <a href="{{ route('admin.products.destroy', ['id' => $pro->id]) }}">--}}
{{--                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> </button>--}}
{{--                                    </a>--}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
<div class="d-flex justify-content-center" style="margin-top: 50px;">
                    <!-- Pagination Links -->
                    {{ $products->links() }}
</div>
                </div>
            </div>
        </div>
    </section>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteProductModal" tabindex="-1" role="dialog" aria-labelledby="confirmProductDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmProductDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_Product_warning') ?? 'Are you sure you want to delete this brand? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteProductBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script>
        function showDeleteProductModal(productId) {
            const url = `{{ url('admin/products/destroy') }}/${productId}`;
            document.getElementById('confirmDeleteProductBtn').setAttribute('href', url);
            $('#confirmDeleteProductModal').modal('show');
        }
    </script>
@endsection
