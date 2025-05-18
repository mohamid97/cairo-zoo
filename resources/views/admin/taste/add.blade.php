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
                        <li class="breadcrumb-item active">{{ __('main.tastes') }} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.tastes') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.tastes.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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


                        <div class="form-group">
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
