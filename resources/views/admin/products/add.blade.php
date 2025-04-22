@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_product') }}</h1> <!-- Translated Title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.add_product') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.product') }}</h3> <!-- Translated Header -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label> <!-- Translated Label -->
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="slug">{{ __('main.slug') }} ({{ $lang->name }}) </label> <!-- Translated Label -->
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ old('slug.' . $lang->code) }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="price">{{ __('main.price') }}</label> <!-- Translated Label -->
                            <input type="text" name="price" class="form-control" id="price" placeholder="{{ __('main.enter_price') }}" value="{{ old('price') }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="old_price">{{ __('main.old_price') }}</label> <!-- Translated Label -->
                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="{{ __('main.enter_old_price') }}" value="{{ old('old_price') }}">
                            @error('old_price')
                            <div class="text-danger">{{ $errors->first('old_price') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discount">{{ __('main.discount') }}</label> <!-- Translated Label -->
                            <input type="text" name="discount" class="form-control" id="discount" placeholder="{{ __('main.enter_discount') }}" value="{{ old('discount') }}">
                            @error('discount')
                            <div class="text-danger">{{ $errors->first('discount') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">{{ __('main.sku') }}</label> <!-- Translated Label -->
                            <input type="text" name="sku" class="form-control" id="sku" placeholder="{{ __('main.enter_sku') }}" value="{{ old('sku') }}">
                            @error('sku')
                            <div class="text-danger">{{ $errors->first('sku') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="video">{{ __('main.video') }}</label> <!-- Translated Label -->
                            <input type="url" name="video" class="form-control" id="video" placeholder="{{ __('main.enter_video') }}" value="{{ old('video') }}">
                            @error('video')
                            <div class="text-danger">{{ $errors->first('video') }}</div>
                            @enderror
                        </div>

                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="description">{{ __('main.des') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">{{ old('des.' . $lang->code) }}</textarea>
                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                <textarea name="meta_title[{{$lang->code}}]" class="ckeditor">{{ old('meta_title.' . $lang->code) }}</textarea>
                                @error('meta_title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">{{ old('meta_des.' . $lang->code) }}</textarea>
                                @error('meta_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label>{{ __('main.category') }}</label> <!-- Translated Label -->
                            <select name="category" class="form-control">
                                <option value="">{{ __('main.select_category') }}</option> <!-- Translated Option -->
                                @forelse($categories as $category)
                                    <option value="{{$category->id}}">{{$category->translate($langs[0]->code)->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('category')
                            <div class="text-danger">{{ $errors->first('category') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>{{ __('main.star') }}</label> <!-- Translated Label -->
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input name="start" type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2"></label>
                                    </div>
                                </div>
                            </div>
                            @error('start')
                            <div class="text-danger">{{ $errors->first('start') }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button> <!-- Translated Button -->
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
