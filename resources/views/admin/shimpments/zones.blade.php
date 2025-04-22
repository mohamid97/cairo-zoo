@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shimpment Zones </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Zones</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>

                <a href="{{route('admin.shimpments.add_zone')}}" style="color: #FFF">
                    <button class="btn btn-info" >
                        <i class="nav-icon fas fa-plus"></i> Add New Zone
                    </button>
                </a>

            </div>
            <br>
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">All Zones</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                             @foreach($langs as $lang)
                                 <th>name ({{$lang->code}})</th>
                             @endforeach
                            <th>price</th>
                            <th>details</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($zones as $index => $zone)
                            <tr>
                                <td>{{$index + 1}}</td>

                                @foreach($langs as $lang)
                                <td>{{(isset($zone->translate($lang->code)->name) ? $zone->translate($lang->code)->name : '')}}</td>
                                @endforeach

                                <td>{{ $zone->price }}</td>
                                <td>{!! $zone->translate(app()->getLocale())->details !!}</td>
                             
                                <td>
                                    <a href="{{route('admin.shimpments.edit_zone' ,  ['id' => $zone->id])}}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> Edit</button>
                                    </a>

                                    @if($zone->deleted_at == null)

                                        <a href="{{route('admin.shimpments.soft_delete_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> Soft Delete</button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.shimpments.restore_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> Restore</button>
                                        </a>
                                    @endif





                                    <a href="{{route('admin.shimpments.destroy_zone' ,  ['id' => $zone->id])}}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> Remove</button>
                                    </a>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"> No Data</td>
                            </tr>
                        @endforelse


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

@endsection
