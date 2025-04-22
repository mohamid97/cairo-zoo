@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('main.events') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('main.events') }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('main.event') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="{{ route('admin.events.update', ['id' => $event->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">




                    <div class="border p-3">
                        @foreach($langs as $lang)
                        <div class="form-group">
                            <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label>
                            <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ isset($event->translate($lang->code)->name) ? $event->translate($lang->code)->name : '' }}">
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
                                <label for="image">{{ __('main.des') }} ({{ $lang->name }})</label>
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">{{ isset($event->translate($lang->code)->des) ? $event->translate($lang->code)->des : '' }}</textarea>
                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="image">{{ __('main.images') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="images[]" type="file" class="custom-file-input" id="image" multiple>
                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">{{ __('main.upload') }}</span>
                            </div>
                        </div>
                        @if($event->images)
                            <div class="d-flex mt-3" style="gap: 10px; position: relative" >
                            @foreach($event->images as $images)

                                    <div>
                                        <img src="{{ asset('uploads/images/events/' . $images->image) }}" width="150px" height="150px">
                                        <p style="position: absolute; bottom: -15%">
                                            <a href="{{route('admin.event.delete_image' , ['id'=>$event->id , 'image_id'=>$images->id])}}">
                                            <button  type="button" class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash"></i></button>
                                            </a>

                                        </p>
                                    </div>


                            @endforeach
                            </div>
                        @endif
                        @error('images.*')
                        <div class="text-danger">{{ $errors->first('images.*') }}</div>
                        @enderror
                    </div>



                    <div class="border p-3">
                        <div class="form-group">
                            <label>{{ __('main.date') }} </label>
                            <input class="form-control"  type="date"  id="date" name="date" required value="{{$event->date}}">


                        </div>
                    </div>



                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('main.save') }}</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
@endsection


