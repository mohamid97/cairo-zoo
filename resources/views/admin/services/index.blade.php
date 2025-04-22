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
                    <h1>{{ __('main.services') }}</h1> <!-- Use translation key -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Use translation key -->
                        <li class="breadcrumb-item active">{{ __('main.services') }}</li> <!-- Use translation key -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('admin.services.add') }}" style="color: #FFF">
                        <button class="btn btn-info">
                            <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_service') }} <!-- Use translation key -->
                        </button>
                    </a>
                </div>

                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.category.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('main.search_by_name') }}"> <!-- Use translation key -->
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i> {{ __('main.search') }} <!-- Use translation key -->
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_services') }}</h3> <!-- Use translation key -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>

                            @foreach($langs as $lang)
                                <th>{{ __('main.name') }} ({{ $lang->code }})</th> <!-- Use translation key -->
                            @endforeach
                            <th>{{ __('main.image') }}</th> <!-- Use translation key -->
                            <th>{{ __('main.action') }}</th> <!-- Use translation key -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($services as $index => $service)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                @foreach($langs as $lang)
                                    <td>
                                        {{ isset($service->translate($lang->code)->name) ? $service->translate($lang->code)->name : '' }}
                                    </td>
                                @endforeach
                                <td>
                                    <img src="{{ asset('uploads/images/service/' . $service->image) }}" width="70px" height="70px">
                                </td>
                                <td>
                                    <a href="{{ route('admin.services.edit', ['id' => $service->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button> <!-- Use translation key -->
                                    </a>

                                    @if($service->deleted_at == null)
                                        <a href="{{ route('admin.services.soft_delete', ['id' => $service->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button> <!-- Use translation key -->
                                        </a>
                                    @else
                                        <a href="{{ route('admin.services.restore', ['id' => $service->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button> <!-- Use translation key -->
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.services.gallery', ['id' => $service->id]) }}">
                                        <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-eye"></i> {{ __('main.show_gallery') }}</button> <!-- Use translation key -->
                                    </a>

                                    <a href="{{ route('admin.services.destroy', ['id' => $service->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button> <!-- Use translation key -->
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($langs) + 3 }}">{{ __('main.no_data') }}</td> <!-- Use translation key -->
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 20px;">
                        {{ $services->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
