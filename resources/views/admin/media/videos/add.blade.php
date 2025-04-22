@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_videos') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.videos') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.videos') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data">
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
                                    <input name="photo" type="file" class="custom-file-input" id="image">
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

                        <div class="form-group">
                            <label for="link">{{ __('main.link') }}</label>
                            <input type="text" name="link" class="form-control" id="link" placeholder="{{ __('main.enter_link') }}" value="{{ old('link') }}">
                            @error('link')
                            <div class="text-danger">{{ $errors->first('link') }}</div>
                            @enderror
                        </div>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="des">{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <input type="text" name="des[{{ $lang->code }}]" class="form-control" id="des" placeholder="{{ __('main.enter_des') }}" value="{{ old('des.' . $lang->code) }}">
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="group_media">{{ __('main.media_group') }}</label>
                            <select name="group_media" class="form-control" id="group_media">
                                @foreach ($media_groups as $media)
                                    <option value="{{ $media->id }}">{{ $media->name }}</option>
                                @endforeach
                            </select>
                            @error('group_media')
                            <div class="text-danger">{{ $errors->first('group_media') }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
