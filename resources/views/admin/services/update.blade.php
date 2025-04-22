@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.update_services') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.update_services') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.services') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.services.update', ['id' => $service->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="border p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ isset($service->translate($lang->code)->name) ? $service->translate($lang->code)->name : '' }}">
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
                                    <label for="slug">{{ __('main.slug') }} ({{ $lang->name }})</label>
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ isset($service->translate($lang->code)->slug) ? $service->translate($lang->code)->slug : '' }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="border p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }})</label>
                                    <input type="text" name="small_des[{{$lang->code}}]" class="form-control" id="small_des" placeholder="{{ __('main.enter_small_des') }}" value="{{ isset($service->translate($lang->code)->small_des) ? $service->translate($lang->code)->small_des : '' }}">
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>


                        <div class="form-group">
                            <label for="price">{{ __('main.price') }} ({{ $lang->name }})</label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="{{ __('main.enter_price') }}" value="{{ $service->price }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>

                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="description">{{ __('main.des') }} ({{$lang->name}})</label>
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">
                                @if (isset($service->translate($lang->code)->des))
                                        {!! $service->translate($lang->code)->des !!}
                                    @endif
                            </textarea>
                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach



                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label>
                                <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">
                                @if (isset($service->translate($lang->code)->meta_des))
                                        {!! $service->translate($lang->code)->meta_des !!}
                                 @endif
                            </textarea>
                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach



                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label>
                                <textarea name="meta_title[{{$lang->code}}]" class="ckeditor">
                                @if (isset($service->translate($lang->code)->meta_title))
                                        {!! $service->translate($lang->code)->meta_title !!}
                                    @endif
                            </textarea>
                                @error('meta_title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach








                    <!-- Repeat similar changes for meta_title and meta_des -->

                        <div class="form-group">
                            <label for="image">{{ __('main.photos') }}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('main.upload') }}</span>
                                </div>
                            </div>
                            <img src="{{ asset('uploads/images/service/' . $service->image) }}" width="70px" height="70px">
                        </div>

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }})</label>
                                <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ isset($service->translate($lang->code)->alt_image) ? $service->translate($lang->code)->alt_image : '' }}">
                                @error('alt_image.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('alt_image.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        <br>

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }})</label>
                                <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ isset($service->translate($lang->code)->title_image) ? $service->translate($lang->code)->title_image : '' }}">
                                @error('title_image.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        <br>

                        <div class="form-group">
                            <label>{{ __('main.category') }}</label>
                            <select type="text" name="category" class="form-control">
                                <option value="0">{{ __('main.select_category') }}</option>
                                @forelse($categories as $category)
                                    <option {{ ($service->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->translate($langs[0]->code)->name }}</option>
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
                                    <label>{{ __('main.star') }}</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{ ($category->star ? 'checked' : '') }} name="star" type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2"></label>
                                    </div>
                                </div>
                            </div>
                            @error('star')
                            <div class="text-danger">{{ $errors->first('star') }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
