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
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.events') }}</h1> <!-- Translated title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translated home -->
                        <li class="breadcrumb-item active">{{ __('main.events') }}</li> <!-- Translated active item -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.events.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_event') }} <!-- Translated button -->
                    </button>
                </a>
            </div>
            <br>

            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.events.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_placeholder') }}"> <!-- Translated placeholder -->
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">
                                <i class="fas fa-search"></i> {{ __('main.search') }} <!-- Translated search button -->
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.brands') }}</h3> <!-- Translated title -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th> <!-- Translated name -->
                            <th>{{ __('main.images')}} </th>
                            <th>{{ __('main.date') }}</th>
                            <th>{{ __('main.action') }}</th> <!-- Translated action -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($events as $index => $event)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $event->name }}</td>
                                @if($event->images)

                                       <td>
                                           @foreach($event->images as $image)
                                               <img src="{{asset('/uploads/images/events/' . $image->image)}}"  height="50px" width="50px"/>
                                           @endforeach
                                     </td>
                                @else
                                    <td>No images</td>
                                @endif

                                <td>{{$event->date}}</td>

                                <td>
                                    <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button> <!-- Translated edit button -->
                                    </a>

                                    <a href="{{ route('admin.events.delete', ['id' => $event->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.delete') }}</button> <!-- Translated soft delete button -->
                                    </a>


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td> <!-- Translated no data message -->
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
