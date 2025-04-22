@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.our_works') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.our_works') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <form method="post" action="{{ route('admin.our_works.save_gallery', ['id' => $our_work->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image">{{ __('main.photo') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="photos[]" type="file" class="custom-file-input" id="image" multiple>
                                <label class="custom-file-label" for="image">{{ __('main.choose_photo') }}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">{{ __('main.upload') }}</span>
                            </div>
                        </div>

                        @foreach($errors->get('photos.*') as $index => $messages)
                            @foreach($messages as $message)
                                <div class="text-danger">{{ $message }}</div>
                            @endforeach
                        @endforeach
                    </div>

                    <button class="btn btn-info" type="submit">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_photo') }}
                    </button>
                </form>
            </div>
            <br>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.gallery') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @forelse($our_work->gallery as $gallery)
                            <div class="col-md-12 col-lg-6 col-xl-4">
                                <div class="card mb-2 bg-gradient-dark">
                                    <img height="300px" class="card-img-top" src="{{ asset('uploads/images/ourworks/'.$gallery->photo) }}" alt="{{ __('main.image') }}">
                                    <a href="{{ route('admin.our_works.delete_gallery', ['id' => $gallery->id]) }}" class="text-white">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.delete') }}</button>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="badge badge-danger">{{ __('main.no_photo') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
