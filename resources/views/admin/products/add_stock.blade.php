@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_stock') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.add_stocks_to_product') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('main.stock') }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.products.store_stock') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label>{{ __('main.products') }}</label>
                            <select type="text" name="product_id" class="form-control">
                                <option value="0">{{ __('main.select_product') }}</option>
                                @forelse($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->translate(app()->getLocale())->name }}</option>
                                @empty
                                    <option disabled>{{ __('main.no_products_available') }}</option>
                                @endforelse
                            </select>
                            @error('product_id')
                            <div class="text-danger">{{ $errors->first('product_id') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">{{ __('main.stock') }}</label>
                            <input type="number" name="stock" class="form-control" id="stock" placeholder="{{ __('main.enter_stock') }}" value="{{ old('stock') }}">
                            @error('stock')
                            <div class="text-danger">{{ $errors->first('stock') }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
