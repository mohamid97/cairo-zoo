@extends('admin.layout.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.achievements') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.achievements') }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.achievements') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.ach.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">


                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
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
                        <div class="border p-3">
                            <div class="form-group">
                                <label>{{ __('main.number') }} </label>
                                <input class="form-control"  type="number"  id="number" name="number">


                            </div>
                        </div>
                        <div class="border p-3">
                            <div class="form-group">
                                <label for="image">{{ __('main.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="icon" type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>
                                @error('icon')
                                  <div class="text-danger">{{ $errors->first('icon') }}</div>
                                @enderror
                            </div>
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
