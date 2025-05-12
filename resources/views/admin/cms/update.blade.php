@extends('admin.layout.master')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ trans('main.edit_article') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('main.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('main.edit_article') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ trans('main.article') }}</h3>
            </div>

            <form role="form" method="post" action="{{ route('admin.cms.update', ['id' => $blog->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="title">{{ trans('main.title') }} ({{ $lang->name }})</label>
                                <input type="text" name="title[{{$lang->code}}]" class="form-control" id="title"
                                    placeholder="{{ trans('main.enter_title') }}"
                                    value="{{ isset($blog->translate($lang->code)->name) ? $blog->translate($lang->code)->name : '' }}">
                                @error('title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="slug">{{ trans('main.slug') }} ({{ $lang->name }})</label>
                                <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug"
                                    placeholder="{{ trans('main.enter_slug') }}"
                                    value="{{ isset($blog->translate($lang->code)->slug) ? $blog->translate($lang->code)->slug : '' }}">
                                @error('slug.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="small_des">{{ trans('main.small_des') }} ({{ $lang->name }})</label>
                                <textarea class="form-control"
                                    name="small_des[{{$lang->code}}]">{{ isset($blog->translate($lang->code)->small_des) ? $blog->translate($lang->code)->small_des : '' }}</textarea>
                                @error('small_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="meta_title">{{ trans('main.meta_title') }} ({{ $lang->name }})</label>
                                <textarea name="meta_title[{{$lang->code}}]"
                                    class="form-control">{{ isset($blog->translate($lang->code)->meta_title) ? $blog->translate($lang->code)->meta_title : '' }}</textarea>
                                @error('meta_title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="meta_des">{{ trans('main.meta_des') }} ({{ $lang->name }})</label>
                                <textarea name="meta_des[{{$lang->code}}]"
                                    class="form-control">{{ isset($blog->translate($lang->code)->meta_des) ? $blog->translate($lang->code)->meta_des : '' }}</textarea>
                                @error('meta_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="image">{{ trans('main.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="image" type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">{{ trans('main.choose_image') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ trans('main.upload') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Current Image -->
                                <div class="mt-3" id="current-image-container">
                                    <img src="{{ asset('uploads/images/cms/' . $blog->image) }}" width="200px" class="img-thumbnail" id="current-image">
                                    <p class="text-muted mt-1">{{ trans('main.current_image') }}</p>
                                </div>
                                
                                <!-- New Image Preview -->
                                <div class="mt-3">
                                    <img id="image-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                                </div>
                                
                                <!-- Upload Progress -->
                                <div class="progress mt-2 d-none" id="upload-progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar">0%</div>
                                </div>
                                
                                @error('image')
                                <div class="text-danger">{{ $errors->first('image') }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="alt_image">{{ trans('main.alt_image') }} ({{ $lang->name }})</label>
                                <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image"
                                    placeholder="{{ trans('main.enter_alt_image') }}"
                                    value="{{ isset($blog->translate($lang->code)->alt_image) ? $blog->translate($lang->code)->alt_image : '' }}">
                                @error('alt_image.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('alt_image.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="title_image">{{ trans('main.title_image') }} ({{ $lang->name }})</label>
                                <input type="text" name="title_image[{{$lang->code}}]" class="form-control"
                                    id="title_image" placeholder="{{ trans('main.enter_title_image') }}"
                                    value="{{ isset($blog->translate($lang->code)->title_image) ? $blog->translate($lang->code)->title_image : '' }}">
                                @error('title_image.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        @foreach($langs as $lang)
                        <div class="form-group">
                            <label for="des">{{ trans('main.des') }} ({{ $lang->name }})</label>
                            <textarea name="des[{{$lang->code}}]"
                                class="ckeditor">{{ isset($blog->translate($lang->code)->des) ? $blog->translate($lang->code)->des : '' }}</textarea>
                            @error('des.' . $lang->code)
                            <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                    <br>

                </div>

                <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-edit"></i>
                            {{ __('main.update') }}
                        </button>
                    </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.getElementById("image").addEventListener("change", function (event) {
        const input = event.target;
        const file = input.files[0];

        if (file) {
            // Hide current image
            document.getElementById('current-image-container').classList.add('d-none');
            
            // Show new image preview
            const preview = document.getElementById("image-preview");
            preview.src = URL.createObjectURL(file);
            preview.classList.remove("d-none");

            // Show and animate progress bar
            const progressBar = document.getElementById("upload-progress-bar");
            const progressContainer = document.getElementById("upload-progress");
            progressContainer.classList.remove("d-none");

            let progress = 0;
            const interval = setInterval(() => {
                if (progress >= 100) {
                    clearInterval(interval);
                } else {
                    progress += 10;
                    progressBar.style.width = progress + "%";
                    progressBar.innerText = progress + "%";
                }
            }, 100);
        } else {
            // If no file selected, show current image again
            document.getElementById('current-image-container').classList.remove('d-none');
            document.getElementById("image-preview").classList.add("d-none");
            document.getElementById("upload-progress").classList.add("d-none");
        }
    });
</script>
@endsection