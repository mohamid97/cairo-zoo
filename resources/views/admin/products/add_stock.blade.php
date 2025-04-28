@extends('admin.layout.master')

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
                        <li class="breadcrumb-item active">{{ __('main.store_stock') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.add_stock') }}</h3>
                </div>



                <form role="form" method="post" action="{{ route('admin.products.store_stock') }}">
                    @csrf
                    <div class="card-body">


                        <div class="border p-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>{{ __('main.products') }}</label>
                                    <select name="product_id" class="form-control select2-search">
                                        <option value="">{{ __('main.select_product') }}</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                                @if($product->sku) ({{ $product->sku }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="text-danger">{{ $errors->first('product_id') }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="quantity">{{ __('main.quantity') }} </label>
                                    <input type="number" name="quantity" class="form-control" id="weight" placeholder="{{ __('main.enter_quantity') }}" value="{{ old('quantity') }}">
                                    @error('quantity')
                                    <div class="text-danger">{{ $errors->first('quantity') }}</div>
                                    @enderror
                                </div>



                            </div>
                        </div>


                        <br>

                        <div class="border p-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="cost_price">{{ __('main.cost_price') }}</label>
                                    <input type="number" name="cost_price" class="form-control" id="cost_price" placeholder="{{ __('main.enter_cost_price') }}" value="{{ old('cost_price') }}">
                                    @error('cost_price')
                                    <div class="text-danger">{{ $errors->first('cost_price') }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="sales_price">{{ __('main.sales_price') }}</label>
                                    <input type="number" name="sales_price" class="form-control" id="sales_price" placeholder="{{ __('main.enter_sales_price') }}" value="{{ old('sales_price') }}">
                                    @error('sales_price')
                                    <div class="text-danger">{{ $errors->first('sales_price') }}</div>
                                    @enderror
                                </div>

                            </div>


                        </div>




                        <!-- Other form fields remain the same -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-search').select2({
                placeholder: "{{ __('main.search_product') }}",
                allowClear: true,
                minimumInputLength: 2,
                width: '100%'
            });
        });
    </script>
@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endsection
