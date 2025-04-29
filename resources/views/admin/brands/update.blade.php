@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.brands') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.brands') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.brand') }}</h3>
                </div>

                <form method="post" action="{{ route('admin.brands.update', ['id' => $brand->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <!-- Name -->
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{ $lang->code }}]" class="form-control"
                                           placeholder="{{ __('main.enter_name') }}"
                                           value="{{ old('name.' . $lang->code, optional($brand->translate($lang->code))->name) }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <!-- Slug -->
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.slug') }} ({{ $lang->name }})</label>
                                    <input type="text" name="slug[{{ $lang->code }}]" class="form-control"
                                           placeholder="{{ __('main.enter_slug') }}"
                                           value="{{ old('slug.' . $lang->code, optional($brand->translate($lang->code))->slug) }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <!-- Description -->
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label>{{ __('main.des') }} ({{ $lang->name }})</label>
                                    <textarea class="ckeditor" name="des[{{ $lang->code }}]" class="form-control"
                                              placeholder="{{ __('main.enter_description') }}">{{ old('des.' . $lang->code, optional($brand->translate($lang->code))->des) }}</textarea>
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
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">{{ __('main.upload') }}</span>
                                </div>
                            </div>
                            <img src="{{ asset('uploads/images/brands/' . $brand->image) }}" width="150px" height="150px">
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
