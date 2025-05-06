@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_new_user') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.users') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.users') }}</h3> <!-- Translated Users title -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf <!-- Laravel CSRF token helper -->
                    <div class="card-body">

                        <div class="border p-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">{{ __('main.first_name') }}</label> <!-- Translated First Name -->
                                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="{{ __('main.enter_first_name') }}" value="{{ old('first_name')  }}">
                                    @error('first_name')
                                    <div class="text-danger">{{ $errors->first('first_name') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="last_name">{{ __('main.last_name') }} </label>
                                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="{{ __('main.enter_last_name') }}" value="{{ old('last_name')   }}">
                                    @error('last_name')
                                    <div class="text-danger">{{ $errors->first('last_name') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <br>


                        <div class="border p-3">
                            <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="password">{{ __('main.password') }} <span class="badge badge-danger">{{__('main.password_regex')}}</span> </label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('main.enter_password') }}" value="{{ old('password')   }}">
                                        @error('password')
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">{{ __('main.confirm_password') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{ __('main.enter_confirm_password') }}">
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <br>




                        <div class="border p-3">
                            <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="email">{{ __('main.email') }}</label> <!-- Translated Email -->
                                        <input type="text" name="email" class="form-control" id="email" placeholder="{{ __('main.enter_email') }}" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="phone">{{ __('main.phone') }}</label> <!-- Translated Phone -->
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ __('main.enter_phone') }}" value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>


                        <br>



                        <div class="border p-3">
                            <div class="row">


                                <div class="form-group col-md-6">
                                    <label for="avatar">{{ __('main.avatar') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="avatar" type="file" class="custom-file-input" id="avatar">
                                            <label class="custom-file-label" for="avatar">{{ __('main.choose_image') }}</label> <!-- Translated Choose Image -->
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



                                    @error('avatar')
                                    <div class="text-danger">{{ $errors->first('avatar') }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="user_type">{{ __('main.user_type') }}</label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="cashier" {{ old('user_type') == 'data_entry' ? 'selected' : '' }}>Cashier</option>
                                        <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="data_entry" {{ old('user_type') == 'data_entry' ? 'selected' : '' }}>Data Entry</option>
                                    </select>
                                    @error('user_type')
                                    <div class="text-danger">{{ $errors->first('user_type') }}</div>
                                    @enderror
                                </div>







                            </div>
                        </div>










                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.save') }}</button> <!-- Translated Update -->
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@section('scripts')

    <script>


        document.getElementById("avatar").addEventListener("change", function (event) {
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
