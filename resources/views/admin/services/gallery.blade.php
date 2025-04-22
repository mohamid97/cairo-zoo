@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.services') }}</h1> <!-- Use translation for "Services" -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Use translation for "Home" -->
                        <li class="breadcrumb-item active">{{ __('main.services') }}</li> <!-- Use translation for "Services" -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <form method="post" action="{{ route('admin.services.save_gallery', ['id' => $service->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="image">{{ __('main.photo') }}</label> <!-- Use translation for "Photo" -->
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="photo[]" type="file" class="custom-file-input" id="image" multiple>
                                <label class="custom-file-label" for="image">{{ __('main.choose_photo') }}</label> <!-- Use translation for "Choose Photo" -->
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Use translation for "Upload" -->
                            </div>
                        </div>

                        @error('photo')
                        <div class="text-danger">{{ $errors->first('photo') }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-info" type="submit">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_photo') }} <!-- Use translation for "Add New Photo" -->
                    </button>
                </form>
            </div>

            <br>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.gallery') }}</h3> <!-- Use translation for "Gallery" -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @forelse($service->gallery as $gallery)
                            <div class="col-md-12 col-lg-6 col-xl-4">
                                <div class="card mb-2 bg-gradient-dark">
                                    <img height="300px" class="card-img-top" src="{{ asset('uploads/images/service/'.$gallery->photo) }}" alt="{{ __('main.gallery_photo_alt') }}"> <!-- Use translation for alt text -->
                                    <a href="{{ route('admin.services.delete_gallery', ['id' => $gallery->id]) }}" class="text-white">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.delete') }}</button> <!-- Use translation for "Delete" -->
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="badge badge-danger">{{ __('main.no_photo') }}</p> <!-- Use translation for "No Photo" -->
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
