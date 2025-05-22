{{-- filepath: /home/mohamed/Desktop/projects/cairo-zoo/resources/views/admin/shimpments/add_city.blade.php --}}
@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('main.cities')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('main.add_city')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('main.add_city')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.shimpments.store_city')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="card-body">


                        <div class="border  p-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">
                                    <label for="name">{{__('main.name')}} ({{ $lang->name }}) </label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{__('main.enter_name')}}" value="{{ old('name.' . $lang->code) }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                        </div>


                        <div class="border  p-3">
                        <div class="form-group">
                            <label for="zone_id">{{__('main.zone')}}</label>
                            <select name="zone_id" class="form-control" id="zone_id">
                                <option value="">{{__('main.select_zone')}}</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                @endforeach
                            </select>
                            @error('zone_id')
                            <div class="text-danger">{{ $errors->first('zone_id') }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{__('main.add')}}</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection