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
                    <h1>{{ __('main.categories') }}</h1> <!-- Use translation key -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Use translation key -->
                        <li class="breadcrumb-item active">{{ __('main.categories') }}</li> <!-- Use translation key -->
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.category.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_category') }} <!-- Use translation key -->
                    </button>
                </a>
            </div>
            <br>

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

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_categories') }}</h3> <!-- Use translation key -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.photo') }}</th> <!-- Use translation key -->
                            @foreach($langs as $lang)
                                <th>{{ __('main.name') }} ({{ $lang->code }})</th> <!-- Use translation key -->
                            @endforeach
                            <th>{{ __('main.type') }}</th> <!-- Use translation key -->

                            <th>{{ __('main.parent') }}</th> <!-- Use translation key -->

                            <th>{{ __('main.action') }}</th> <!-- Use translation key -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>
                                    <img src="{{ asset('uploads/images/category/' . $cat->photo) }}" width="150px" height="150px">
                                </td>
                                @foreach($langs as $lang)
                                    <td>{{ isset($cat->translate($lang->code)->name) ? $cat->translate($lang->code)->name : '' }}</td>
                                @endforeach
                                <td>
                                    @if($cat->type == 0)
                                        <span class="badge badge-danger">{{ __('main.parent') }}</span> <!-- Use translation key -->
                                    @else
                                        <span class="badge badge-primary">{{ __('main.child') }}</span> <!-- Use translation key -->
                                    @endif
                                </td>
                                <td>{{($cat->parent) ? $cat->parent->name : null}}</td>
                                <td>

                                    <a href="{{ route('admin.category.edit', ['id' => $cat->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }} <!-- Use translation key -->
                                        </button>
                                    </a>

                                    @if($cat->deleted_at == null)
                                        <a href="{{ route('admin.category.soft_delete', ['id' => $cat->id]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }} <!-- Use translation key -->
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.category.restore', ['id' => $cat->id]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }} <!-- Use translation key -->
                                            </button>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.category.destroy', ['id' => $cat->id]) }}">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }} <!-- Use translation key -->
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td> <!-- Use translation key -->
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $categories->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
