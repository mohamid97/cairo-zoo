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
                <form method="post" action="{{ route('admin.products.files.store', ['id' => $product->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="file_name">{{ __('main.file_name') }}</label>
                        <input type="text" name="file_name" class="form-control" id="file_name" placeholder="{{ __('main.enter_file_name') }}">

                        @error('file_name')
                        <div class="text-danger">{{ $errors->first('file_name') }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">{{ __('main.file') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="file" type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">{{ __('main.choose_file') }}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">{{ __('main.upload') }}</span>
                            </div>
                        </div>

                        @error('file')
                        <div class="text-danger">{{ $errors->first('file') }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-info" type="submit">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_file') }}
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
                        @forelse($product->files as $file)
                            <div class="col-md-12 col-lg-6 col-xl-4">
                                <div class="card mb-2">
                                    <div class="card-body" style="display: flex; flex-direction: column; align-items: center;">
                                        @if(!empty($file->file))
                                            <h5 class="card-title" style="background: #535353; padding: 10px; color: #FFF; border-radius: 5px; margin-bottom: 10px; width: 100%; text-align: center;">{{ $file->name }}</h5>
                                        @else
                                            <h5 class="card-title" style="background: #535353; padding: 10px; color: #FFF; border-radius: 5px; margin-bottom: 10px; width: 100%; text-align: center;">{{ __('main.file') }} {{ $loop->iteration }}</h5>
                                        @endif
                                        <div>
                                            <a href="{{ asset('uploads/images/products/'.$file->file) }}" target="_blank" class="text-white">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-file"></i> {{ __('main.view_file') }}</button>
                                            </a>
                                            <a href="{{ route('admin.products.files.delete', ['id' => $file->id]) }}" class="text-white">
                                                <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.delete') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="badge badge-danger">{{ __('main.no_file') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
