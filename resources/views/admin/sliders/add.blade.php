@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_slider') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.sliders') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>ش

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.slider') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label>
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
                                    <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="small_des[{{ $lang->code }}]" class="form-control" id="small_des" placeholder="{{ __('main.enter_small_des') }}" value="{{ old('small_des.' . $lang->code) }}">
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="des">{{ __('main.des') }} ({{ $lang->name }}) </label>
                                    <textarea class="ckeditor" name="des[{{ $lang->code }}]" class="form-control" id="des" placeholder="{{ __('main.enter_des') }}">{{ old('des.' . $lang->code) }}</textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="arrange">{{ __('main.arrange') }}</label>
                            <input type="number" name="arrange" class="form-control" id="arrange" placeholder="{{ __('main.enter_arrange') }}" value="{{ old('arrange') }}">
                            @error('arrange')
                            <div class="text-danger">{{ $errors->first('arrange') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="link">{{ __('main.link') }}</label>
                            <input type="text" name="link" class="form-control" id="link" placeholder="{{ __('main.enter_link') }}" value="{{ old('link') }}">
                            @error('link')
                            <div class="text-danger">{{ $errors->first('link') }}</div>
                            @enderror
                        </div>

                        <!-- Video Upload -->
                        <div class="form-group">
                            <label for="video">{{ __('main.video') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="video" type="file" class="custom-file-input" id="video">
                                    <label class="custom-file-label" for="video">{{ __('main.choose_video') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span>
                                </div>
                            </div>
                            @error('video')
                            <div class="text-danger">{{ $errors->first('video') }}</div>
                            @enderror
                        </div>

                        <br>




                        <div class="form-group">
                            <label for="image">{{ __('main.image') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span>
                                </div>
                            </div>
                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }}) </label>
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
                                    <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="title_image[{{ $lang->code }}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ old('title_image.' . $lang->code) }}">
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
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
