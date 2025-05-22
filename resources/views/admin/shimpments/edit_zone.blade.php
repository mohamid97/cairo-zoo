@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('main.zones')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active"> {{__('main.update_zone')}} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('main.zone')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.shimpments.update_zone' , ['id' => $zone->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">
                            <div class="row">
                        @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="name">{{__('main.name')}} ({{ $lang->name }}) </label>
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{__('main.enter_name')}}" value=" {{isset($zone->translate($lang->code)->name) ? $zone->translate($lang->code)->name : ''}} ">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                            </div>
                        </div>
                        <br>


                        <div class="border  p-3">

                        <div class="form-group">
                            <label for="price">{{__('main.price')}}  </label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="{{__('main.enter_price')}}" value="{{$zone->price }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>
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

