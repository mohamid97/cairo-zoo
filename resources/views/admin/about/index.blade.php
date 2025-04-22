@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.about_us') }}</h1> <!-- Translation key for "About Us" -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translation key for "Home" -->
                        <li class="breadcrumb-item active">{{ __('main.about_us') }}</li> <!-- Translation key for "About Us" -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.about_us') }}</h3> <!-- Translation key for "About Us" -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                @csrf <!-- Using Blade directive for CSRF token -->
                    <div class="card-body">

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label> <!-- Translation key for "Name" -->
                                    <input type="text" name="name[{{ $lang->code }}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ ($about) && isset($about->translate($lang->code)->name) ? $about->translate($lang->code)->name : '' }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="phone">{{ __('main.phone') }}</label> <!-- Translation key for "Phone" -->
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ __('main.enter_phone') }}" value="{{ ($about) ? $about->phone :'' }}">
                            @error('phone')
                            <div class="text-danger">{{ $errors->first('phone') }}</div>
                            @enderror
                        </div>

                        <br>

                        <div class="border p-3">
                            @foreach($langs as $index => $lang)
                                <div class="form-group">
                                    <label for="des">{{ __('main.des') }} ({{ $lang->name }})</label> <!-- Translation key for "Description" -->
                                    <textarea name="des[{{ $lang->code }}]" class="ckeditor">{{ ($about) && isset($about->translate($lang->code)->des) ? $about->translate($lang->code)->des : '' }}</textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="image">{{ __('main.image') }}</label> <!-- Translation key for "Image" -->
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="photo" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translation key for "Choose Image" -->
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translation key for "Upload" -->
                                </div>
                            </div>
                            @if(($about) && $about->photo && $about->photo != null)
                                <img src="{{ asset('uploads/images/about/' . $about->photo) }}" width="150px" height="150px">
                            @endif

                            @error('photo')
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @enderror
                        </div>

                        <br>
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }})</label> <!-- Translation key for "Alt Image" -->
                                    <input type="text" name="alt_image[{{ $lang->code }}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ ($about) && isset($about->translate($lang->code)->alt_image) ? $about->translate($lang->code)->alt_image : '' }}">
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
                                    <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }})</label> <!-- Translation key for "Title Image" -->
                                    <input type="text" name="title_image[{{ $lang->code }}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ ($about) && isset($about->translate($lang->code)->title_image) ? $about->translate($lang->code)->title_image : '' }}">
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="meta_title">{{ __('main.meta_title') }} ({{ $lang->name }})</label> <!-- Translation key for "Meta Title" -->
                                    <textarea name="meta_title[{{ $lang->code }}]" class="ckeditor">
                                        @if (($about) && isset($about->translate($lang->code)->meta_title))
                                            {!! $about->translate($lang->code)->meta_title !!}
                                        @endif
                                    </textarea>

                                    @error('meta_title.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="meta_des">{{ __('main.meta_des') }} ({{ $lang->name }})</label> <!-- Translation key for "Meta Description" -->
                                    <textarea name="meta_des[{{ $lang->code }}]" class="ckeditor">
                                        @if (($about) && isset($about->translate($lang->code)->meta_des))
                                            {!! $about->translate($lang->code)->meta_des !!}
                                        @endif
                                    </textarea>

                                    @error('meta_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button> <!-- Translation key for "Update" -->
                    </div>

                </form>
            </div>





        </div>
    </section>
@endsection

