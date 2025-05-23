@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{__('main.feedbacks')}} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{__('main.feedbacks')}} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>

                    <a href="{{route('admin.feedback.add')}}" style="color: #FFF">
                        <button class="btn btn-info" >
                            <i class="nav-icon fas fa-plus"></i> {{__('main.new_feedback')}}
                        </button>
                    </a>

            </div>
            <br>
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">{{__('main.all_feedbacks')}}</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 100px">{{__('main.image')}}</th>
                            <th>{{__('main.name')}}</th>
                            <th>{{__('main.small_des')}}</th>
                            <th>{{__('main.action')}}</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($feedbacks as $index => $feed)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{asset('uploads/images/feedbacks/'. $feed->image)}}" width="150px" height="150px">
                                </td>
                                <td>{{$feed->name}}</td>
                                <td>{{$feed->small_des}}</td>
                                <td>
                                    <a href="{{route('admin.feedback.edit' ,  ['id' => $feed->id])}}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> {{__('main.edit')}}</button>
                                    </a>

                                    @if($feed->deleted_at == null)

                                        <a href="{{route('admin.feedback.soft_delete' ,  ['id' => $feed->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i>{{__('main.soft_delete')}}</button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.feedback.restore' ,  ['id' => $feed->id])}}">
                                            <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-trash-restore"></i> {{__('main.restore')}}</button>
                                        </a>
                                    @endif





                                    <a href="{{route('admin.feedback.destroy' ,  ['id' => $feed->id])}}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{__('main.remove')}}</button>
                                    </a>

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
