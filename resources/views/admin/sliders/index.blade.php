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
                    <h1>{{ __('main.sliders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.sliders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="mb-3">
                <div>
                    <a href="{{ route('admin.sliders.add') }}" class="btn btn-info ml-2">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_image') }}
                    </a>
                </div>
                <br>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.sliders.index') }}" class="input-group">
                            <input type="text" name="search" value="{{ $searchTerm }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_by_name') }}">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i> {{ __('main.search') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_sliders') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ __('main.index') }}</th>
                            <th style="width: 100px">{{ __('main.image') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sliders as $index => $slider)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('uploads/images/sliders/' . $slider->image) }}" width="150px" height="150px" alt="{{ $slider->translate($langs[0]->code)->name }}">
                                </td>
                                <td>{{ $slider->translate($langs[0]->code)->name }}</td>
                                <td>
                                    <a href="{{ route('admin.sliders.edit', ['id' => $slider->id]) }}" class="btn btn-sm btn-info">
                                        <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}
                                    </a>
                                    @if($slider->deleted_at == null)
                                        <a href="{{ route('admin.sliders.soft_delete', ['id' => $slider->id]) }}" class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}
                                        </a>
                                    @else
                                        <a href="{{ route('admin.sliders.restore', ['id' => $slider->id]) }}" class="btn btn-sm btn-success">
                                            <i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.sliders.destroy', ['id' => $slider->id]) }}" class="btn btn-sm btn-danger">
                                        <i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ __('main.no_data_found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $sliders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
