@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_files') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.files') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.files') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.files.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{ $lang->code }}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

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
                        <br>

                        <div class="form-group">
                            <label for="file">{{ __('main.file') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="file" type="file" class="custom-file-input" id="file">
                                    <label class="custom-file-label" for="file">{{ __('main.choose_file') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">{{ __('main.upload') }}</span>
                                </div>
                            </div>

                            @error('file')
                            <div class="text-danger">{{ $errors->first('file') }}</div>
                            @enderror
                        </div>

                        <div class="border p-3">
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

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
