@extends('admin.layout.master')
@section('styles')
    <style>
        svg {
            font-size: 5px;
            width: 28px;
        }
        .text-sm {
            margin-top: 26px;
            font-size: .875rem !important;
        }
        .gap-2{
            gap: 10px;
        }
    </style>
@endsection

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
                        <li class="breadcrumb-item active">{{__('main.zones')}}</li>
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
                        <i class="nav-icon fas fa-plus"></i> {{__('main.add_new_zone')}}
                    </button>
                </a>

            </div>
            <br>
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">{{__('main.all_zones')}}</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                             <th>{{__('main.name')}}</th>
                            <th>{{__('main.price')}}</th>
                            <th>{{__('main.action')}}</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($zones as $index => $zone)
                            <tr>
                                <td>{{$index + 1}}</td>

                                <td>{{$zone->name}}</td>
                                

                                <td>{{ $zone->price }}</td>
                             
                             
                                <td>

                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{route('admin.shimpments.edit_zone' ,  ['id' => $zone->id])}}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> </button>
                                    </a>

                                    {{-- @if($zone->deleted_at == null)

                                        <a href="{{route('admin.shimpments.soft_delete_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i>  </button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.shimpments.restore_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> Restore</button>
                                        </a>
                                    @endif --}}





                                    <a href="{{route('admin.shimpments.destroy_zone' ,  ['id' => $zone->id])}}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> </button>
                                    </a>

                                    </div>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"> {{__('main.no_data')}}</td>
                            </tr>
                        @endforelse


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

@endsection
