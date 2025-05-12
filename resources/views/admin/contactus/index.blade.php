@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('main.contact_us') }}</h1> <!-- Translation for Contact Us -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translation for Home -->
                    <li class="breadcrumb-item active">{{ __('main.contact_us') }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('main.contact_us') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="{{ route('admin.contact.update') }}" enctype="multipart/form-data">
                @csrf
                <!-- Blade directive for CSRF token -->
                <div class="card-body">

                    <div class="border p-3">
                        <div class="row">

                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                <!-- Translation for Name -->
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name"
                                    placeholder="{{ __('main.enter_name') }}"
                                    value="{{ ($contactus) && isset($contactus->translate($lang->code)->name) ? $contactus->translate($lang->code)->name : '' }}">
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
                                <label for="address">{{ __('main.address') }} ({{ $lang->name }})</label>
                                <!-- Translation for Address -->
                                <input type="text" name="address[{{$lang->code}}]" class="form-control" id="address"
                                    placeholder="{{ __('main.enter_address') }}"
                                    value="{{($contactus) &&  isset($contactus->translate($lang->code)->address) ? $contactus->translate($lang->code)->address : '' }}">
                                @error('address.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('address.' . $lang->code) }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>

                    <div class="border p-3">
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="phone1">{{ __('main.phone1') }}</label> <!-- Translation for Phone 1 -->
                                <input type="text" name="phone1" class="form-control" id="phone1"
                                    placeholder="{{ __('main.enter_phone1') }}"
                                    value="{{ ($contactus) ? $contactus->phone1 : '' }}">
                                @error('phone1')
                                <div class="text-danger">{{ $errors->first('phone1') }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone2">{{ __('main.phone2') }}</label> <!-- Translation for Phone 2 -->
                                <input type="text" name="phone2" class="form-control" id="phone2"
                                    placeholder="{{ __('main.enter_phone2') }}"
                                    value="{{ ($contactus) ? $contactus->phone2 : '' }}">
                                @error('phone2')
                                <div class="text-danger">{{ $errors->first('phone2') }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone3">{{ __('main.phone3') }}</label> <!-- Translation for Phone 3 -->
                                <input type="text" name="phone3" class="form-control" id="phone3"
                                    placeholder="{{ __('main.enter_phone3') }}"
                                    value="{{($contactus) ?   $contactus->phone3 : '' }}">
                                @error('phone3')
                                <div class="text-danger">{{ $errors->first('phone3') }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <br>



                    <div class="border p-3">
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="email">{{ __('main.email') }}</label> <!-- Translation for Email -->
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="{{ __('main.enter_email') }}"
                                    value="{{ ($contactus)  ? $contactus->email : '' }}">
                                @error('email')
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="image">{{ __('main.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="photo" type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label"
                                            for="image">{{ __('main.choose_image') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>

                                @if($contactus && $contactus->photo)
                                <div class="mt-3" id="old-image-container">
                                    <img src="{{ asset('uploads/images/contactus/' . $contactus->photo) }}" alt="Image"
                                        class="img-thumbnail" style="max-width: 250px;">
                                </div>
                                @endif

                                <div class="mt-3">
                                    <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none"
                                        style="max-width: 200px;">
                                </div>

                                <div class="progress mt-2 d-none" id="upload-progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;"
                                        id="upload-progress-bar">0%</div>
                                </div>

                                @error('photo')
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                                @enderror
                            </div>



                        </div>
                    </div>


                    <br>
                    <div class="border p-3">
                        <div class="row">
                            @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }})</label>
                                <!-- Translation for Alt Image -->
                                <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image"
                                    placeholder="{{ __('main.enter_alt_image') }}"
                                    value="{{($contactus) &&  isset($contactus->translate($lang->code)->alt_image) ? $contactus->translate($lang->code)->alt_image : '' }}">
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
                                <!-- Translation for Title Image -->
                                <input type="text" name="title_image[{{$lang->code}}]" class="form-control"
                                    id="title_image" placeholder="{{ __('main.enter_title_image') }}"
                                    value="{{ ($contactus) && isset($contactus->translate($lang->code)->title_image) ? $contactus->translate($lang->code)->title_image : '' }}">
                                @error('title_image.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
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
                                <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label>
                                <!-- Translation for Meta Title -->
                                <textarea name="meta_title[{{$lang->code}}]"
                                    class="form-control">{{($contactus) &&  isset($contactus->translate($lang->code)->meta_title) ? $contactus->translate($lang->code)->meta_title : '' }}</textarea>
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
                                <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label>
                                <!-- Translation for Meta Description -->
                                <textarea name="meta_des[{{$lang->code}}]"
                                    class="form-control">{{ ($contactus) && isset($contactus->translate($lang->code)->meta_des) ? $contactus->translate($lang->code)->meta_des : '' }}</textarea>
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
                            <div class="form-group col-md-6">
                                <label for="location1">{{ __('main.location') }} 1 (Map)</label>
                                <!-- Translation for Meta Description -->
                                <textarea name="location1"
                                    class="form-control">{{ ($contactus) && isset($contactus->location1) ? $contactus->location1 : '' }}</textarea>
                                @error('location1')
                                <div class="text-danger">{{ $errors->first('location1') }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="location2">{{ __('main.location') }} 2 (Map)</label>
                                <!-- Translation for Meta Description -->
                                <textarea name="location2"
                                    class="form-control">{{ ($contactus) && isset($contactus->location2) ? $contactus->location2 : '' }}</textarea>
                                @error('location2')
                                <div class="text-danger">{{ $errors->first('location2') }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>





                    <div class="border p-3">

                        @foreach($langs as $lang)
                        <div class="form-group">
                            <label for="des">{{ __('main.des') }} ({{$lang->name}})</label>
                            <!-- Translation for Description -->
                            <textarea name="des[{{$lang->code}}]"
                                class="ckeditor">{{ ($contactus) && isset($contactus->translate($lang->code)->des) ? $contactus->translate($lang->code)->des : '' }}</textarea>
                            @error('des.' . $lang->code)
                            <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                    <br>








                    <br>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <i class="nav-icon fas fa-edit"></i>
                        {{ __('main.update') }}
                    </button>
                </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection

@section('scripts')
<script>
// Image preview and hide old image
document.getElementById("image").addEventListener("change", function(event) {
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