@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('main.pages')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('main.pages')}} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('main.pages')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.pages.update' , ['id' => $page->id])}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">


                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">{{__('main.name')}} ({{ $lang->name }}) </label>
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{__('main.enter_name')}}" value="{{ isset($page->translate($lang->code)->name) ? $page->translate($lang->code)->name : '' }}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach


                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{__('main.slug')}} ({{ $lang->name }}) </label>
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="name" placeholder="{{__('main.enter_slug')}}" value="{{ isset($page->translate($lang->code)->slug) ? $page->translate($lang->code)->slug : '' }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach



                        @foreach($langs as $index => $lang)


                            <div class="form-group">
                                <label for="description">{{__('main.des')}} ({{$lang->name}})</label>
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">
                                    @if (isset($page->translate($lang->code)->des))
                                        {{$page->translate($lang->code)->des}}
                                    @endif

                                </textarea>

                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach



                        <div class="form-group">
                            <label for="image">{{__('main.photo')}}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose Photo</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>

                            <img src="{{asset('uploads/images/pages/'. $page->image)}}" width="150px" height="150px">

                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>

                        <br>
                        <div class="border  p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="alt_image">{{__('main.alt_image')}} ({{ $lang->name }}) </label>
                                    <input type="text" name="alt_image[{{$lang->code}}]" class="form-control" id="alt_image" placeholder="{{__('main.enter_alt_image')}}" value="{{ isset($page->translate($lang->code)->alt_image) ? $page->translate($lang->code)->alt_image :'' }}">
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
                                    <label for="title_image">{{__('main.title_image')}}  ({{ $lang->name }}) </label>
                                    <input type="text" name="title_image[{{$lang->code}}]" class="form-control" id="title_image" placeholder="{{__('main.enter_title_image')}}" value="{{ isset($page->translate($lang->code)->title_image) ? $page->translate($lang->code)->title_image : '' }}">
                                    @error('title_image.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title_image.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>




                        <div class="border  p-3">

                            @foreach($langs as $index => $lang)

                                <div class="form-group">
                                    <label for="meta_title">{{__('main.meta_title')}}({{$lang->name}})</label>
                                    <textarea name="meta_title[{{$lang->code}}]" class="ckeditor">

                                            @if (isset($page->translate($lang->code)->meta_title))

                                            {{$page->translate($lang->code)->meta_title}}

                                        @endif

                                        </textarea>

                                    @error('meta_title.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach

                        </div>

                        <br>

                        <div class="border  p-3">


                            @foreach($langs as $index => $lang)
                                <div class="form-group">
                                    <label for="meta_des">{{__('main.meta_des')}}({{$lang->name}})</label>
                                    <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">
                                            @if (isset($page->translate($lang->code)->meta_des))
                                            {{$page->translate($lang->code)->meta_des}}
                                        @endif

                                        </textarea>

                                    @error('meta_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach

                        </div>




                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> Update</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection
