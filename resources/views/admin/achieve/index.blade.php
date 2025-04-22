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
                    <h1>{{ __('main.achievements') }}</h1> <!-- Translated title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translated home -->
                        <li class="breadcrumb-item active">{{ __('main.achievements') }}</li> <!-- Translated active item -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.ach.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_achievement') }} <!-- Translated button -->
                    </button>
                </a>
            </div>
            <br>

            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.ach.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $searchTerm }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_placeholder') }}"> <!-- Translated placeholder -->
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
                    <h3 class="card-title">{{ __('main.achievements') }}</h3> <!-- Translated title -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th> <!-- Translated name -->
                            <th>{{ __('main.icon')}} </th>
                            <th>{{ __('main.number') }}</th>
                            <th>{{ __('main.action') }}</th> <!-- Translated action -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($achieves as $index => $ach)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ach->name }}</td>

                                <td>
                                    <img src="{{asset('/uploads/images/achievements/' . $ach->icon)}}" height="50" width="50" />

                                </td>

                                <td>{{$ach->number}}</td>

                                <td>
                                    <a href="{{ route('admin.ach.edit', ['id' => $ach->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button> <!-- Translated edit button -->
                                    </a>

                                    <a href="{{ route('admin.ach.delete', ['id' => $ach->id]) }}">
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
                        {{ $achieves->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



