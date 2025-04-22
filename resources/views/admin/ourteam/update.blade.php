@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.our_team') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.our_team') }} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.our_team') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.ourteam.update' , ['id'=> $team->id]) }}"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="title">Title ({{ $lang->name }}) </label>
                                    <input type="text" name="title[{{$lang->code}}]" class="form-control" id="title" placeholder="Enter Title" value="{{ isset($team->translate($lang->code)->title)? $team->translate($lang->code)->title:'' }}">
                                    @error('title.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('title.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>



                        <div class="border  p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">Name ({{ $lang->name }}) </label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="Enter Name" value="{{ isset($team->translate($lang->code)->name) ? $team->translate($lang->code)->name : '' }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>










                        <div class="border  p-3">

                            @foreach($langs as $index => $lang)

                                <div class="form-group">
                                    <label for="image">Description ({{$lang->name}})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">

                                    @if (isset($team->translate($lang->code)->des))
                                            {!! $team->translate($lang->code)->des  !!}
                                        @endif


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
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/teams/'. $team->image)}}" width="150px" height="150px">
                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>

                        <br>


                        <div class="border p-3">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Enter Facebook Link" value="{{ $team->facebook }}">
                                @error('facebook')
                                <div class="text-danger">{{ $errors->first('facebook') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="twitter">Twitter</label>
                                <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Enter Twitter Link" value="{{ $team->twitter }}">
                                @error('twitter')
                                <div class="text-danger">{{ $errors->first('twitter') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input type="text" name="instagram" class="form-control" id="instagram" placeholder="Enter Instagram Link" value="{{ $team->instagram }}">
                                @error('instagram')
                                <div class="text-danger">{{ $errors->first('instagram') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube">YouTube</label>
                                <input type="text" name="youtube" class="form-control" id="youtube" placeholder="Enter YouTube Link" value="{{ $team->youtube }}">
                                @error('youtube')
                                <div class="text-danger">{{ $errors->first('youtube') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tiktok">TikTok</label>
                                <input type="text" name="tiktok" class="form-control" id="tiktok" placeholder="Enter TikTok Link" value="{{ $team->tiktok }}">
                                @error('tiktok')
                                <div class="text-danger">{{ $errors->first('tiktok') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="linkedin">LinkedIn</label>
                                <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="Enter LinkedIn Link" value="{{ $team->linkedin }}">
                                @error('linkedin')
                                <div class="text-danger">{{ $errors->first('linkedin') }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>












                        {{--                        <div class="form-group">--}}
                        {{--                            <label>Category</label>--}}
                        {{--                            <select type="text" name="category" class="form-control">--}}
                        {{--                                <option value="0">Select Category</option>--}}
                        {{--                                @forelse($categories as $category)--}}
                        {{--                                    <option value="{{$category->id}}">{{$category->translate($langs[0]->code)->name}}</option>--}}
                        {{--                                @empty--}}
                        {{--                                @endforelse--}}

                        {{--                            </select>--}}
                        {{--                            @error('category')--}}
                        {{--                            <div class="text-danger">{{ $errors->first('category') }}</div>--}}
                        {{--                            @enderror--}}
                        {{--                        </div>--}}


                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection

