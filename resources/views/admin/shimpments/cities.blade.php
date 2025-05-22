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
                    <h1>{{__('main.cities')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('main.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('main.cities')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>

                <a href="{{route('admin.shimpments.add_city')}}" style="color: #FFF">
                    <button class="btn btn-info" >
                        <i class="nav-icon fas fa-plus"></i> {{__('main.add_new_city')}}
                    </button>
                </a>

            </div>
            <br>
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">{{__('main.all_city')}}</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                             <th>{{__('main.name')}}</th>
                            <th>{{__('main.zone')}}</th>
                            <th>{{__('main.action')}}</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($cities as $index => $city)
                            <tr>
                                <td>{{$index + 1}}</td>

                                <td>{{$city->name}}</td>
                                

                                <td>{{ $city->zone->name }} -  ( {{$city->zone->price}}) </td>
                             
                             
                                <td>

                                    <div class="d-flex align-items-center justify-content-center gap-2">

                                    {{-- @if($zone->deleted_at == null)

                                        <a href="{{route('admin.shimpments.soft_delete_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i>  </button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.shimpments.restore_zone' ,  ['id' => $zone->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> Restore</button>
                                        </a>
                                    @endif --}}





                                    <a href="{{route('admin.shimpments.destroy_city' ,  ['id' => $city->id])}}">
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
