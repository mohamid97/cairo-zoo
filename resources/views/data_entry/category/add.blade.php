@extends('data_entry.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_category') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.add_category') }}</li>
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
                <form role="form" method="post" action="{{ route('data_entry.category.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                        <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
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
                                        <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ old('slug.' . $lang->code) }}">
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
                                            <option value="0">{{ __('main.parent') }}</option>
                                            <option value="1">{{ __('main.child') }}</option>
                                        </select>
                                        @error('type')
                                        <div class="text-danger">{{ $errors->first('type') }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="parent_id_field">
                                        <label>{{ __('main.select_category') }}</label>
                                        <select name="parent_id" class="form-control">
                                            <option disabled>{{ __('main.select_category') }}</option>
                                            @forelse($categories as $category)
                                                <option value="{{$category->id}}">{{$category->translate($langs[0]->code)->name}}</option>
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
                                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translated Choose Image -->
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translated Upload -->
                                            </div>
                                        </div>

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

                                        <div class="mt-3">
                                            <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 70px;">
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
                                        <textarea name="small_des[{{$lang->code}}]" class="form-control" ></textarea>
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
                                        <textarea name="des[{{$lang->code}}]" class="ckeditor"></textarea>
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
                                        <textarea name="meta_title[{{$lang->code}}]" class="form-control"></textarea>
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
                                        <textarea name="meta_des[{{$lang->code}}]"  class="form-control"></textarea>
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
                                        <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ old('alt_image.' . $lang->code) }}">
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
                                        <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ old('title_image.' . $lang->code) }}">
                                        @error('title_image.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <br>

{{--                        <div class="form-group">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <label>{{ __('main.star') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input name="star" type="checkbox" class="custom-control-input" id="customCheck2">--}}
{{--                                        <label class="custom-control-label" for="customCheck2"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @error('star')--}}
{{--                            <div class="text-danger">{{ $errors->first('star') }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.save') }}</button>
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



        document.getElementById("thumbinal").addEventListener("change", function (event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                // Preview Image
                const preview = document.getElementById("avatar-preview-thumbinal");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                // Simulated Progress
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
            $('#parent_id_field').hide();
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
