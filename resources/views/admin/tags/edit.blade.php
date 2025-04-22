@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('main.update_tag')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('main.home')</a></li>
                        <li class="breadcrumb-item active">@lang('main.update_tag')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('main.tag')</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.tags.update', ['id'=> $tag->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">@lang('main.name') ({{ $lang->name }})</label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="@lang('main.enter_name')" value="{{ isset($tag->translate($lang->code)->name) ? $tag->translate($lang->code)->name : '' }}">
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
                                    <label for="slug">@lang('main.slug') ({{ $lang->name }})</label>
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="@lang('main.enter_slug')" value="{{ isset($tag->translate($lang->code)->slug) ? $tag->translate($lang->code)->slug : '' }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $index => $lang)
                                <div class="form-group">
                                    <label for="meta_title">@lang('main.meta_title') ({{ $lang->name }})</label>
                                    <textarea name="meta_title[{{$lang->code}}]" class="form-control">
                                        {{ isset($tag->translate($lang->code)->meta_title) ? $tag->translate($lang->code)->meta_title : '' }}
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
                                    <label for="meta_des">@lang('main.meta_des') ({{ $lang->name }})</label>
                                    <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">
                                        {{ isset($tag->translate($lang->code)->meta_des) ? $tag->translate($lang->code)->meta_des : '' }}
                                    </textarea>
                                    @error('meta_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i class="nav-icon fas fa-paper-plane"></i> @lang('main.update')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
