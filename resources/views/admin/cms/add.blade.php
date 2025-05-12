@extends('admin.layout.master')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ trans('main.add_article') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('main.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('main.add_article') }}</li>
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

            <form role="form" method="post" action="{{ route('admin.cms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="title">{{ trans('main.title') }} ({{ $lang->name }})</label>
                                <input type="text" name="title[{{$lang->code}}]" class="form-control" id="title"
                                    placeholder="{{ trans('main.enter_title') }}"
                                    value="{{ old('title.' . $lang->code) }}">
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
                                    value="{{ old('slug.' . $lang->code) }}">
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
                                    name="small_des[{{$lang->code}}]">{{ old('small_des.' . $lang->code) }}</textarea>
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
                                    class="form-control">{{ old('meta_title.' . $lang->code) }}</textarea>
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
                                    class="form-control">{{ old('meta_des.' . $lang->code) }}</textarea>
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
                            <label for="image">{{ __('main.image') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translated Choose Image -->
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translated Upload -->
                                </div>
                            </div>

                            <div class="mt-3">
                                <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                            </div>


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
                                    value="{{ old('alt_image.' . $lang->code) }}">
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
                                    value="{{ old('title_image.' . $lang->code) }}">
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
                                class="ckeditor">{{ old('des.' . $lang->code) }}</textarea>
                            @error('des.' . $lang->code)
                            <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                    <br>










                </div>

                <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.add') }}</button>
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
                // Preview Image
                const preview = document.getElementById("avatar-preview");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                // Simulated Progress
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
            }
        });





    </script>
@endsection