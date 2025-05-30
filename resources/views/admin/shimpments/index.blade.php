@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>About Us</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('main.Shimpments')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('main.setting')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.shimpments.update')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">

                            <div class="form-group" >
                                <label>{{__('main.type')}}</label>
                                <select type="text" name="is_free" class="form-control" id="type">
                                    <option value="paid" {{($shimp && $shimp->is_free ) === 'paid' ? 'selected':''}}>{{__('main.paid')}}</option>
                                    <option value="free" {{($shimp && $shimp->is_free) === 'free' ?'selected':''}}>{{__('main.free')}}</option>
                                </select>
                                @error('is_free')
                                <div class="text-danger">{{ $errors->first('is_free') }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>





                        <div class="border  p-3">

                            <div class="form-group" >
                                <label>{{__('main.min_to_free')}}</label>
                                <input type="number" name="min_to_free" class="form-control" value="{{ ($shimp && $shimp->min_to_free ) ? $shimp->min_to_free : '' }}"/>

                                @error('min_to_free')
                                <div class="text-danger">{{ $errors->first('min_to_free') }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>













                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> Update</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection


