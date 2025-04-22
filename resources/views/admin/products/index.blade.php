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
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <!-- Category Filter -->
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="form-group">
                            <select name="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ __('main.filter_by_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                        {{ $category->translate(app()->getLocale())->name }}
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
                            @foreach($langs as $lang)
                                <th>{{ __('main.name') }} ({{$lang->code}})</th>
                            @endforeach
                            <th>{{ __('main.category') }}</th>
                            <th>{{ __('main.stock') }}</th>
                            <th>{{ __('main.sku') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $index => $pro)
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>
                                @foreach($langs as $lang)
                                    <td>{{ isset($pro->translate($lang->code)->name) ? $pro->translate($lang->code)->name : '' }}</td>
                                @endforeach
                                <td>
                                    @forelse($categories as $cat)
                                        @if($cat->id == $pro->category_id)
                                            <span class="badge badge-danger">{{ $cat->translate($langs[0]->code)->name }}</span>
                                        @endif
                                    @empty
                                    @endforelse
                                </td>
                                <td>{{ $pro->stock }}</td>
                                <td>{{ $pro->sku }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', ['id' => $pro->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button>
                                    </a>
                                    <a href="{{ route('admin.products.files', ['id' => $pro->id]) }}">
                                        <button class="btn btn-sm btn-success"><i class="fas fa-file"></i> {{ __('main.file') }}</button>
                                    </a>

                                    <a href="{{ route('admin.products.props', ['id' => $pro->id]) }}">
                                        <button class="btn btn-sm btn-success"><i class="fas fa-setting"></i> {{ __('main.prop') }}</button>
                                    </a>


                                    @if($pro->deleted_at == null)
                                        <a href="{{ route('admin.products.soft_delete', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.products.restore', ['id' => $pro->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.products.gallery', ['id' => $pro->id]) }}">
                                        <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-edit"></i> {{ __('main.show_gallery') }}</button>
                                    </a>
                                    <a href="{{ route('admin.products.destroy', ['id' => $pro->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button>
                                    </a>
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
@endsection
