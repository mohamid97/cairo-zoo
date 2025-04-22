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
                    <h1>{{ __('main.pages') }}</h1> <!-- Translated Our Works title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translated Home -->
                        <li class="breadcrumb-item active">{{ __('main.pages') }}</li> <!-- Translated Active Item -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.pages.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_page') }} <!-- Translated Add New Work -->
                    </button>
                </a>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.pages.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $searchTerm }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_by_name') }}">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">
                                <i class="fas fa-search"></i> {{ __('main.search') }} <!-- Translated Search -->
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.pages') }}</h3> <!-- Translated Our Works title -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <td>{{ __('main.name') }} </td> <!-- Translated Name -->
                            <th>{{ __('main.photo') }}</th> <!-- Translated Photo -->
                            <th>{{ __('main.slug') }}</th> <!-- Translated Link -->
                            <th>{{ __('main.action') }}</th> <!-- Translated Action -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pages as $index => $page)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $page->name ?? '' }}</td>
                                <td>
                                    <img src="{{ asset('uploads/images/pages/' . $page->image) }}" width="150px" height="150px" alt="{{ __('main.pages') }}"> <!-- Added alt text -->
                                </td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }} <!-- Translated Edit -->
                                        </button>
                                    </a>

                                    @if($page->deleted_at == null)
                                        <a href="{{ route('admin.pages.soft_delete', ['id' => $page->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button> <!-- Translated Soft Delete -->
                                        </a>
                                    @else
                                        <a href="{{ route('admin.pages.restore', ['id' => $page->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button> <!-- Translated Restore -->
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.pages.destroy', ['id' => $page->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button> <!-- Translated Remove -->
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($langs) + 4 }}">{{ __('main.no_data') }}</td> <!-- Translated No Data -->
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $pages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
