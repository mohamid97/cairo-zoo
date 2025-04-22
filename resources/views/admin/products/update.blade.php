@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.update_product') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.update_product') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.product') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <div class="border p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ isset($product->translate($lang->code)->name) ? $product->translate($lang->code)->name : '' }}">
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
                                    <label for="slug">{{ __('main.slug') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ isset($product->translate($lang->code)->slug) ? $product->translate($lang->code)->slug : '' }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach

                        </div>
                        <br>

                        <div class="form-group">
                            <label for="price">{{ __('main.price') }}</label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="{{ __('main.enter_price') }}" value="{{ $product->price }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="old_price">{{ __('main.old_price') }}</label>
                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="{{ __('main.enter_old_price') }}" value="{{ $product->old_price }}">
                            @error('old_price')
                            <div class="text-danger">{{ $errors->first('old_price') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discount">{{ __('main.discount') }}</label>
                            <input type="text" name="discount" class="form-control" id="discount" placeholder="{{ __('main.enter_discount') }}" value="{{ $product->discount }}">
                            @error('discount')
                            <div class="text-danger">{{ $errors->first('discount') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">{{ __('main.sku') }}</label>
                            <input type="text" name="sku" class="form-control" id="sku" placeholder="{{ __('main.enter_sku') }}" value="{{ $product->sku }}">
                            @error('sku')
                            <div class="text-danger">{{ $errors->first('sku') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="video">{{ __('main.video') }}</label>
                            <input type="video" name="video" class="form-control" id="video" placeholder="{{ __('main.enter_video') }}" value="{{ $product->video }}">
                            @error('video')
                            <div class="text-danger">{{ $errors->first('video') }}</div>
                            @enderror
                        </div>

                        <div class="border p-3">
                            @foreach($langs as $index => $lang)

                                <div class="form-group">
                                    <label for="image">{{ __('main.des') }} ({{$lang->name}})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">
                                        @if (isset($product->translate($lang->code)->des))
                                            {!! $product->translate($lang->code)->des !!}
                                        @endif
                                    </textarea>

                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $index => $lang)
                                <div class="form-group">
                                    <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label>
                                    <textarea name="meta_title[{{$lang->code}}]" class="ckeditor">
                                       @if (isset($product->translate($lang->code)->meta_title))
                                            {!! $product->translate($lang->code)->meta_title !!}
                                        @endif
                                    </textarea>

                                    @error('meta_title.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="border p-3">
                            @foreach($langs as $index => $lang)
                                <div class="form-group">
                                    <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label>
                                    <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">
                                     @if (isset($product->translate($lang->code)->meta_des))
                                            {!! $product->translate($lang->code)->meta_des !!}
                                        @endif
                                </textarea>

                                    @error('meta_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="form-group">
                            <label>{{ __('main.category') }}</label>
                            <select type="text" name="category" class="form-control">
                                <option value="">{{ __('main.select_category') }}</option>
                                @forelse($categories as $category)
                                    <option value="{{$category->id}}" {{($category->id == $product->category_id) ? 'selected' : ''}}>{{$category->translate($langs[0]->code)->name}}</option>
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
                                        <input {{($category->star ? 'checked' : '')}} name="star" type="checkbox" class="custom-control-input" id="customCheck2">
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
