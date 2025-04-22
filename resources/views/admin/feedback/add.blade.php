@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('main.new_feedback')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('main.feedbacks')}} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('main.feedbacks')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.feedback.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                            <div class="border p-3">
                                @foreach($langs as $lang)
                                    <div class="form-group">
                                        <label for="name">Name ({{ $lang->name }}) </label>
                                        <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{__('main.enter_name')}}" value="{{ old('name.' . $lang->code) }}">
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
                                    <label for="small_des">Small des ({{ $lang->name }}) </label>
                                    <input type="text" name="small_des[{{$lang->code}}]" class="form-control" id="small_des" placeholder="{{__('main.enter_small_des')}}" value="{{ old('name.' . $lang->code) }}">
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>



                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="des"> Description ({{ $lang->name }}) </label>
                                    <textarea class="ckeditor"  type="text" name="des[{{$lang->code}}]" class="form-control" id="des" placeholder="{{__('main.enter_des')}}">
                                        {{ old('name.' . $lang->code) }}
                                    </textarea>
                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>






                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{__('main.choose_image')}}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">{{__('main.upload')}}</span>
                                </div>
                            </div>

                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>
                        <br>



                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="icon" type="file" class="custom-file-input" id="icon">
                                    <label class="custom-file-label" for="image">{{__('main.choose_icon')}}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">{{__('main.upload')}}</span>
                                </div>
                            </div>

                            @error('icon')
                            <div class="text-danger">{{ $errors->first('icon') }}</div>
                            @enderror
                        </div>








                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{__('main.save')}}</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection
