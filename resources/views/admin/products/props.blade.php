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
                        <li class="breadcrumb-item active">{{ __('main.product_file') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <form method="post" action="{{ route('admin.products.props.store', ['id' => $product->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="border p-3">
                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>


                    <div class="border p-3">
                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="value">{{ __('main.des') }} ({{ $lang->name }})</label>
                                <input type="text" name="value[{{$lang->code}}]" class="form-control" id="value" placeholder="{{ __('main.enter_des') }}" value="{{ old('value.' . $lang->code) }}">
                                @error('value.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('value.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>



                    <button class="btn btn-info" type="submit">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.save') }}
                    </button>

                </form>
            </div>
            <br>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.files') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @forelse($product->props as $prop)
                            <div class="col-md-12 col-lg-6 col-xl-4">
                                <div class="card mb-2">
                                    <div class="card-body" style="display: flex; flex-direction: column; align-items: center;">

                                        <h5 class="card-title" style="background: #535353; padding: 10px; color: #FFF; border-radius: 5px; margin-bottom: 10px; width: 100%; text-align: center;">{{ $prop->name }}</h5>
                                        <p>{{$prop->value}}</p>

                                        <div>
                                            <a href="{{ route('admin.products.props.delete', ['id' => $prop->id]) }}" class="text-white">
                                                <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.delete') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="badge badge-danger">{{ __('main.no_data') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
