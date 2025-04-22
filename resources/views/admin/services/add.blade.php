@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_service') }}</h1> <!-- Use translation key -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Use translation key -->
                        <li class="breadcrumb-item active">{{ __('main.add_services') }}</li> <!-- Use translation key -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.services') }}</h3> <!-- Use translation key -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }})</label> <!-- Use translation key -->
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}"> <!-- Use translation key -->
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
                                    <label for="slug">{{ __('main.slug') }} ({{ $lang->name }})</label> <!-- Use translation key -->
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ old('slug.' . $lang->code) }}"> <!-- Use translation key -->
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
                                    <label for="small_des">{{ __('main.small_des') }} ({{ $lang->name }})</label> <!-- Use translation key -->
                                    <input type="text" name="small_des[{{$lang->code}}]" class="form-control" id="small_des" placeholder="{{ __('main.enter_small_des') }}" value="{{ old('small_des.' . $lang->code) }}"> <!-- Use translation key -->
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>



                        <div class="form-group">
                            <label for="price">{{ __('main.price') }}</label> <!-- Use translation key -->
                            <input type="text" name="price" class="form-control" id="price" placeholder="{{ __('main.enter_price') }}" value="{{ old('price') }}"> <!-- Use translation key -->
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="description">{{ __('main.des') }} ({{$lang->name}})</label> <!-- Use translation key -->
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor"></textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label> <!-- Use translation key -->
                                <textarea name="meta_title[{{$lang->code}}]" class="ckeditor"></textarea>
                                @error('meta_title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="meta_description">{{ __('main.meta_des') }} ({{$lang->name}})</label> <!-- Use translation key -->
                                <textarea name="meta_des[{{$lang->code}}]" class="ckeditor"></textarea>
                                @error('meta_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="border p-3">
                            <div class="form-group">
                                <label for="image">{{ __('main.image') }}</label> <!-- Use translation key -->
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="image" type="file" class="custom-file-input" id="image">
                                        <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Use translation key -->
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">{{ __('main.upload') }}</span> <!-- Use translation key -->
                                    </div>
                                </div>
                                @error('image')
                                <div class="text-danger">{{ $errors->first('image') }}</div>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{ __('main.alt_image') }} ({{ $lang->name }}) </label> <!-- Use translation key -->
                                    <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image" placeholder="{{ __('main.enter_alt_image') }}" value="{{ old('alt_image.' . $lang->code) }}"> <!-- Use translation key -->
                                    @error('alt_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('alt_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="title_image">{{ __('main.title_image') }} ({{ $lang->name }}) </label> <!-- Use translation key -->
                                    <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image" placeholder="{{ __('main.enter_title_image') }}" value="{{ old('title_image.' . $lang->code) }}"> <!-- Use translation key -->
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>

                        <div class="form-group">
                            <label>{{ __('main.category') }}</label> <!-- Use translation key -->
                            <select type="text" name="category" class="form-control">
                                <option value="0">{{ __('main.select_category') }}</option> <!-- Use translation key -->
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
                                    <label>{{ __('main.star') }}</label> <!-- Use translation key -->
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
                        <button type="submit" class="btn btn-info"><i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button> <!-- Use translation key -->
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
