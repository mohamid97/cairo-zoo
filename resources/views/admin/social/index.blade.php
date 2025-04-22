@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.title') }}</h1> <!-- Translated title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translated home -->
                        <li class="breadcrumb-item active">{{ __('main.title') }}</li> <!-- Translated active item -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.title') }}</h3> <!-- Translated title -->
                </div>
                <!-- /.card-header -->
                <form role="form" method="post" action="{{ route('admin.social_media.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        @foreach (['facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'snapchat', 'tiktok', 'skype', 'whatsup', 'email', 'phone'] as $socialMedia)
                            <div class="form-group">
                                <label for="{{ $socialMedia }}">{{ __('main.' . $socialMedia) }}</label> <!-- Translated label -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" name="{{ $socialMedia }}" class="form-control" id="{{ $socialMedia }}" placeholder="{{ __('main.enter_' . $socialMedia) }}" value="{{ $social->$socialMedia }}">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{ ($social->{$socialMedia . '_option'} ? 'checked' : '') }} name="{{ $socialMedia . '_option' }}" type="checkbox" class="custom-control-input" id="customCheck{{ $loop->index }}">
                                            <label class="custom-control-label" for="customCheck{{ $loop->index }}"></label>
                                        </div>
                                    </div>
                                </div>
                                @error($socialMedia)
                                <div class="text-danger">{{ $errors->first($socialMedia) }}</div>
                                @enderror
                            </div>
                        @endforeach

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button> <!-- Translated button -->
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // function updateInputName(checkbox) {
        //     const inputName = checkbox.checked ? 'true' : 'false';
        //     checkbox.value = inputName;
        // }
    </script>
@endsection
