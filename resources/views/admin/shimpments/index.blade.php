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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shimpments</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">About Us</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.shimpments.update')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">

                            <div class="form-group" >
                                <label>Type</label>
                                <select type="text" name="is_free" class="form-control" id="type">
                                    <option value="free" {{$shimp->is_free == 'free' ?'selected':''}}>Free</option>
                                    <option value="paid" {{$shimp->is_free == 'paid' ?'selected':''}}>Paid</option>
                                </select>
                                @error('is_free')
                                <div class="text-danger">{{ $errors->first('is_free') }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>






                            <div class="border p-3">
            
                                <div class="form-group">
                                    <label for="details">Details </label>
                                    <textarea name="details" class="ckeditor">
                                      {{isset($shimp->details)?$shimp->details:''}}
                                    </textarea>

                                    @error('details')
                                    <div class="text-danger">{{ $errors->first('details') }}</div>
                                    @enderror
                                </div>
                      
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


