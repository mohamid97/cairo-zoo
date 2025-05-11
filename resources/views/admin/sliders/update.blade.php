@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.edit_slider') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.sliders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.slider') }}</h3>
                </div>
                
                <form role="form" method="post" action="{{ route('admin.sliders.update', ['id' => $slider->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <!-- Name Fields -->
                        <div class="border p-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">   
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" placeholder="{{ __('main.enter_name') }}" 
                                           value="{{ $slider->translate($lang->code)->name ?? '' }}">
                                    @error('name.' . $lang->code)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <br>

                        <!-- Small Description Fields -->
                        <div class="border p-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">
                                    <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }})</label>
                                    <input type="text" name="small_des[{{$lang->code}}]" class="form-control" placeholder="{{ __('main.enter_small_des') }}" 
                                           value="{{ $slider->translate($lang->code)->small_des ?? '' }}">
                                    @error('small_des.' . $lang->code)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <br>

                        <!-- Description Fields -->
                        <div class="border p-3 mt-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <textarea class="ckeditor form-control" name="des[{{$lang->code}}]" placeholder="{{ __('main.enter_des') }}">
                                        {{ $slider->translate($lang->code)->des ?? '' }}
                                    </textarea>
                                    @error('des.' . $lang->code)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>


                        <!-- Arrange and Link -->   
                        <div class="border p-3 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('main.arrange') }}</label>
                                        <input type="number" name="arrange" class="form-control" value="{{ $slider->arrange }}">
                                        @error('arrange')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('main.link') }}</label>
                                        <input type="text" name="link" class="form-control" value="{{ $slider->link }}">
                                        @error('link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="border p-3 mt-3">
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('main.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="image-upload">
                                        <label class="custom-file-label" for="image-upload">{{ __('main.choose_image') }}</label>
                                    </div>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="progress mt-2 d-none" id="image-progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                
                                <!-- Existing Image -->
                                @if($slider->image)
                                <div class="mt-3" id="existing-image">
                                    <img src="{{ asset('uploads/images/sliders/' . $slider->image) }}" class="img-thumbnail" width="200">
                                    <div class="mt-2">
                                        <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
                                    </div>
                                </div>
                                @endif
                                
                                <!-- New Image Preview -->
                                <div class="mt-3 d-none" id="new-image-preview">
                                    <img id="image-preview" class="img-thumbnail" width="200">
                                </div>
                                
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('main.video') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="video" class="custom-file-input" id="video-upload">
                                        <label class="custom-file-label" for="video-upload">{{ __('main.choose_video') }}</label>
                                    </div>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="progress mt-2 d-none" id="video-progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                
                                <!-- Existing Video -->
                                @if($slider->video)
                                <div class="mt-3" id="existing-video">
                                    <video width="300" controls class="img-thumbnail">
                                        <source src="{{ asset('uploads/videos/sliders/' . $slider->video) }}" type="video/mp4">
                                    </video>
                                    <div class="mt-2">
                                        <input type="hidden" name="remove_video" id="remove-video-flag" value="0">
                                    </div>
                                </div>
                                @endif
                                
                                <!-- New Video Preview -->
                                <div class="mt-3 d-none" id="new-video-preview">
                                    <video id="video-preview" controls class="img-thumbnail" width="300"></video>
                                </div>
                                
                                @error('video')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            </div>

                        </div>


                        <!-- Alt Image Fields -->
                        <div class="border p-3 mt-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.alt_image') }} ({{ $lang->name }})</label>
                                    <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" 
                                           value="{{ $slider->translate($lang->code)->alt_image ?? '' }}">
                                    @error('alt_image.' . $lang->code)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <br>

                        <!-- Title Image Fields -->
                        <div class="border p-3 mt-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.title_image') }} ({{ $lang->name }})</label>
                                    <input type="text" name="title_image[{{$lang->code}}]" class="form-control" 
                                           value="{{ $slider->translate($lang->code)->title_image ?? '' }}">
                                    @error('title_image.' . $lang->code)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
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
    $(document).ready(function() {
        // Image Upload Handling
        $('#image-upload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Show progress bar
                $('#image-progress').removeClass('d-none');
                
                // Simulate upload progress
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    $('#image-progress .progress-bar').css('width', progress + '%');
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        // Hide existing image
                        $('#existing-image').addClass('d-none');
                        $('#remove-image-flag').val('0');
                        
                        // Show new image preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image-preview').attr('src', e.target.result);
                            $('#new-image-preview').removeClass('d-none');
                        }
                        reader.readAsDataURL(file);
                    }
                }, 100);
            }
        });

        // Video Upload Handling
        $('#video-upload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Show progress bar
                $('#video-progress').removeClass('d-none');
                
                // Simulate upload progress
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    $('#video-progress .progress-bar').css('width', progress + '%');
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        // Hide existing video
                        $('#existing-video').addClass('d-none');
                        $('#remove-video-flag').val('0');
                        
                        // Show new video preview
                        const videoPreview = $('#video-preview')[0];
                        videoPreview.src = URL.createObjectURL(file);
                        $('#new-video-preview').removeClass('d-none');
                    }
                }, 100);
            }
        });

        // Remove Image
        $('#remove-image').on('click', function() {
            $('#existing-image').addClass('d-none');
            $('#remove-image-flag').val('1');
            $('#image-upload').val('');
        });

        // Remove Video
        $('#remove-video').on('click', function() {
            $('#existing-video').addClass('d-none');
            $('#remove-video-flag').val('1');
            $('#video-upload').val('');
        });

        // Update filename in file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
</script>
@endsection