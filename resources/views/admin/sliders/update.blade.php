@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.edit_slider') }}</h1> <!-- Translation key for "Edit Slider" -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translation key for "Home" -->
                        <li class="breadcrumb-item active">{{ __('main.sliders') }}</li> <!-- Translation key for "Sliders" -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.slider') }}</h3> <!-- Translation key for "Slider" -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.sliders.update', ['id' => $slider->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label> <!-- Translation key for "Name" -->
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ isset($slider->translate($lang->code)->name) ? $slider->translate($lang->code)->name : '' }}">
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
                                    <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }}) </label> <!-- Translation key for "Small Description" -->
                                    <input type="text" name="small_des[{{$lang->code}}]" class="form-control" id="small_des" placeholder="{{ __('main.enter_small_des') }}" value="{{ isset($slider->translate($lang->code)->small_des) ? $slider->translate($lang->code)->small_des : '' }}">
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="des">{{ __('main.des') }} ({{ $lang->name }}) </label> <!-- Translation key for "Description" -->
                                    <textarea class="ckeditor" name="des[{{$lang->code}}]" class="form-control" id="des" placeholder="{{ __('main.enter_des') }}">
                                        @if (isset($slider->translate($lang->code)->des))
                                            {!! $slider->translate($lang->code)->des !!}
                                        @endif
                                    </textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="arrange">{{ __('main.arrange') }}</label> <!-- Translation key for "Arrange" -->
                            <input name="arrange" type="text" class="form-control" id="arrange" placeholder="{{ __('main.enter_arrange') }}" value="{{ $slider->arrange }}">
                            @error('arrange')
                            <div class="text-danger">{{ $errors->first('arrange') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="link">{{ __('main.link') }}</label> <!-- Translation key for "Link" -->
                            <input name="link" type="text" class="form-control" id="link" placeholder="{{ __('main.enter_link') }}" value="{{ $slider->link }}">
                            @error('link')
                            <div class="text-danger">{{ $errors->first('link') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">{{ __('main.image') }}</label> <!-- Translation key for "Image" -->
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translation key for "Choose Image" -->
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translation key for "Upload" -->
                                </div>
                            </div>

                            <img src="{{ asset('uploads/images/sliders/'. $slider->image) }}" width="150px" height="150px">

                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="video">{{ __('main.video') }}</label> <!-- Translation key for "Video" -->
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="video" type="file" class="custom-file-input" id="video">
                                    <label class="custom-file-label" for="video">{{ __('main.choose_video') }}</label> <!-- Translation key for "Choose Video" -->
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translation key for "Upload" -->
                                </div>
                            </div>

                            @if($slider->video)
                                <video width="300" height="300" controls>
                                    <source src="{{ asset('uploads/videos/sliders/'. $slider->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                            @error('video')
                            <div class="text-danger">{{ $errors->first('video') }}</div>
                            @enderror
                        </div>


                        <br>


                        <div class="border p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }}) </label> <!-- Translation key for "Alt Image" -->
                                    <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ isset($slider->translate($lang->code)->alt_image) ? $slider->translate($lang->code)->alt_image  : '' }}">
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
                                    <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }}) </label> <!-- Translation key for "Title Image" -->
                                    <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ isset($slider->translate($lang->code)->title_image) ? $slider->translate($lang->code)->title_image : '' }}">
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button> <!-- Translation key for "Update" -->
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
