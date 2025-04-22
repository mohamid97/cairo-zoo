@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.edit_des') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.des') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.des') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.des.update', ['id' => $des->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name_{{ $lang->code }}">{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{ $lang->code }}]" class="form-control" id="name_{{ $lang->code }}" placeholder="{{ __('main.enter_name') }}" value="{{ $des->translate($lang->code)->name }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="des_{{ $lang->code }}">{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <textarea class="ckeditor form-control" name="des[{{ $lang->code }}]" id="des_{{ $lang->code }}" placeholder="{{ __('main.enter_des') }}">{{ $des->translate($lang->code)->des }}</textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
