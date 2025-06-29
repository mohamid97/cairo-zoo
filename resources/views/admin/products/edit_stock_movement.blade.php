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
                        <li class="breadcrumb-item active">{{ __('main.update_stock') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.update_stock') }} - {{$stock_movemnt->product->name}}</h3>
                </div>



                <form role="form" method="post" action="{{ route('admin.products.update_stock') }}">
                    @csrf
                    <div class="card-body">

                        <input type="hidden" value="{{$stock_movemnt->id}}" name="stock_id" />

                        <div class="border p-3">
                            <div class="row">




                                <div class="form-group col-md-12">
                                    <label for="quantity">{{ __('main.quantity') }} </label>
                                    <input type="number" name="quantity" class="form-control" id="quantity" placeholder="{{ __('main.enter_quantity') }}" value="{{ $stock_movemnt->quantity}}">
                                    @error('quantity')
                                    <div class="text-danger">{{ $errors->first('quantity') }}</div>
                                    @enderror
                                </div>

   




                            </div>
                        </div>


                        <br>

 




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
