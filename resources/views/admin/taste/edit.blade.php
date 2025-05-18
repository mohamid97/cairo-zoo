@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.tastes') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.tastes') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.tastes') }}</h3>
                </div>

                <form method="post" action="{{ route('admin.tastes.update', ['id' => $taste->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <!-- Name -->
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label>{{ __('main.name') }} ({{ $lang->name }})</label>
                                        <input type="text" name="name[{{ $lang->code }}]" class="form-control"
                                               placeholder="{{ __('main.enter_name') }}"
                                               value="{{ old('name.' . $lang->code, optional($taste->translate($lang->code))->name) }}">
                                        @error('name.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        <!-- Slug -->
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label>{{ __('main.slug') }} ({{ $lang->name }})</label>
                                        <input type="text" name="slug[{{ $lang->code }}]" class="form-control"
                                               placeholder="{{ __('main.enter_slug') }}"
                                               value="{{ old('slug.' . $lang->code, optional($taste->translate($lang->code))->slug) }}">
                                        @error('slug.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        <!-- Description -->
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <textarea class="ckeditor" name="des[{{ $lang->code }}]" class="form-control"
                                              placeholder="{{ __('main.enter_description') }}">{{ old('des.' . $lang->code, optional($taste->translate($lang->code))->des) }}</textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <!-- Image -->
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

                            @if($taste->image)
                                <div class="mt-3" id="old-image-container">
                                    <img src="{{ asset('uploads/images/taste/' . $taste->image) }}" alt="Image" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif

                            

                            <div class="mt-3">
                                <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                            </div>

                            <div class="progress mt-2 d-none" id="upload-progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar">0%</div>
                            </div>

                            @error('photo')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>

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
        // Image preview and hide old image
        document.getElementById("image").addEventListener("change", function (event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                const preview = document.getElementById("avatar-preview");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                const oldImageContainer = document.getElementById("old-image-container");
                if (oldImageContainer) {
                    oldImageContainer.classList.add("d-none");
                }

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
