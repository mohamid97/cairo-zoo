@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.edit_category') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.edit_category') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.category') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.category.update', $cat->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                        <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name"
                                               placeholder="{{ __('main.enter_name') }}"
                                               value="{{ old('name.' . $lang->code, $cat->translate($lang->code)->name ?? '') }}">
                                        @error('name.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
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
                                        <label for="slug">{{ __('main.slug') }} ({{ $lang->name }})</label>
                                        <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug"
                                               placeholder="{{ __('main.enter_slug') }}"
                                               value="{{ old('slug.' . $lang->code, $cat->translate($lang->code)->slug ?? '') }}">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('main.type') }}</label>
                                        <select name="type" class="form-control" id="type">
                                            <option value="0" {{ $cat->type == 0 ? 'selected' : '' }}>{{ __('main.parent') }}</option>
                                            <option value="1" {{ $cat->type == 1 ? 'selected' : '' }}>{{ __('main.child') }}</option>
                                        </select>
                                        @error('type')
                                        <div class="text-danger">{{ $errors->first('type') }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="parent_id_field" style="{{ $cat->type == 0 ? 'display:none' : '' }}">
                                        <label>{{ __('main.select_category') }}</label>
                                        <select name="parent_id" class="form-control">
                                            <option disabled>{{ __('main.select_category') }}</option>
                                            @forelse($categories as $category)
                                                @if($category->id != $cat->id) {{-- Prevent selecting self as parent --}}
                                                <option value="{{$category->id}}" {{ $cat->parent_id == $category->id ? 'selected' : '' }}>
                                                    {{$category->translate($langs[0]->code)->name}}
                                                </option>
                                                @endif
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('parent_id')
                                        <div class="text-danger">{{ $errors->first('parent_id') }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="thumbinal">{{ __('main.thumbinal') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbinal" type="file" class="custom-file-input" id="thumbinal">
                                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('main.upload') }}</span>
                                            </div>
                                        </div>

                                        @if($cat->thumbinal)
                                            <div class="mt-2">
                                                <img src="{{ asset('uploads/images/category/' . $cat->thumbinal) }}" alt="Thumbinal" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        @endif

                                        <div class="mt-3">
                                            <img id="avatar-preview-thumbinal" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                                        </div>

                                        <div class="progress mt-2 d-none" id="upload-progress-thumbinal">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar-thumbinal">0%</div>
                                        </div>

                                        @error('thumbinal')
                                        <div class="text-danger">{{ $errors->first('thumbinal') }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{ __('main.image') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="photo" type="file" class="custom-file-input" id="image">
                                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('main.upload') }}</span>
                                            </div>
                                        </div>

                                        @if($cat->photo)
                                            <div class="mt-2">
                                                <img src="{{ asset('uploads/images/category/' . $cat->photo) }}" alt="Image" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        @endif

                                        <div class="mt-3">
                                            <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                                        </div>

                                        <div class="progress mt-2 d-none" id="upload-progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar">0%</div>
                                        </div>

                                        @error('photo')
                                        <div class="text-danger">{{ $errors->first('photo') }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }})</label>
                                        <textarea name="small_des[{{$lang->code}}]" class="form-control">{{ old('small_des.' . $lang->code, $cat->translate($lang->code)->small_des ?? '') }}</textarea>
                                        @error('small_des.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">{{ old('des.' . $lang->code, $cat->translate($lang->code)->des ?? '') }}</textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>

                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="meta_title">{{ __('main.meta_title') }} ({{ $lang->name }})</label>
                                        <textarea name="meta_title[{{$lang->code}}]" class="form-control">{{ old('meta_title.' . $lang->code, $cat->translate($lang->code)->meta_title ?? '') }}</textarea>
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
                                        <label for="meta_des">{{ __('main.meta_des') }} ({{ $lang->name }})</label>
                                        <textarea name="meta_des[{{$lang->code}}]" class="form-control">{{ old('meta_des.' . $lang->code, $cat->translate($lang->code)->meta_des ?? '') }}</textarea>
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
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }})</label>
                                        <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image"
                                               placeholder="{{ __('main.enter_alt_image') }}"
                                               value="{{ old('alt_image.' . $lang->code, $cat->translate($lang->code)->alt_image ?? '') }}">
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
                                        <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }})</label>
                                        <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image"
                                               placeholder="{{ __('main.enter_title_image') }}"
                                               value="{{ old('title_image.' . $lang->code, $cat->translate($lang->code)->title_image ?? '') }}">
                                        @error('title_image.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-paper-plane"></i>  {{ __('main.update') }}
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
                const preview = document.getElementById("avatar-preview");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

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

        document.getElementById("thumbinal").addEventListener("change", function (event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                const preview = document.getElementById("avatar-preview-thumbinal");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                const progressBar = document.getElementById("upload-progress-bar-thumbinal");
                const progressContainer = document.getElementById("upload-progress-thumbinal");
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

        $(document).ready(function() {
            $('#type').change(function() {
                if ($(this).val() == '1') {
                    $('#parent_id_field').show();
                } else {
                    $('#parent_id_field').hide();
                }
            });
        });
    </script>
@endsection
