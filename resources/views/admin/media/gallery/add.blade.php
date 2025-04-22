@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_photo_to_gallery') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.gallery') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.gallery') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                <input type="text" name="name[{{ $lang->code }}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label for="image">{{ __('main.photo') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="photo" type="file" class="custom-file-input" id="image" required>
                                    <label class="custom-file-label" for="image">{{ __('main.choose_photo') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span>
                                </div>
                            </div>
                            @error('photo')
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @enderror
                        </div>

                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }})</label>
                                    <input type="text" name="alt_image[{{ $lang->code }}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ old('alt_image.' . $lang->code) }}">
                                    @error('alt_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('alt_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }})</label>
                                    <input type="text" name="title_image[{{ $lang->code }}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ old('title_image.' . $lang->code) }}">
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="border p-3">
                            <div class="form-group">
                                <label for="group_media">{{ __('main.media_group') }}</label>
                                <select name="group_media" class="form-control" id="group_media" required>
                                    @foreach ($media_groups as $media)
                                        <option value="{{ $media->id }}">{{ $media->name }}</option>
                                    @endforeach
                                </select>
                                @error('group_media')
                                <div class="text-danger">{{ $errors->first('group_media') }}</div>
                                @enderror
                            </div>
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
