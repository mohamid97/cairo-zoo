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
                    <h1>{{ __('main.our_works') }}</h1> <!-- Translated Our Works title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Translated Home -->
                        <li class="breadcrumb-item active">{{ __('main.our_works') }}</li> <!-- Translated Active Item -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.our_works.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_work') }} <!-- Translated Add New Work -->
                    </button>
                </a>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.our_works.index') }}" class="input-group">
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
                    <h3 class="card-title">{{ __('main.our_works') }}</h3> <!-- Translated Our Works title -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            @foreach($langs as $lang)
                                <td>{{ __('main.name') }} ({{ $lang->code }})</td> <!-- Translated Name -->
                            @endforeach
                            <th>{{ __('main.photo') }}</th> <!-- Translated Photo -->
                            <th>{{ __('main.icon') }}</th> <!-- Translated Icon -->
                            <th>{{ __('main.link') }}</th> <!-- Translated Link -->
                            <th>{{ __('main.action') }}</th> <!-- Translated Action -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($our_works as $index => $work)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                @foreach($langs as $lang)
                                    <td>{{ optional($work->translate($lang->code))->name ?? '' }}</td>
                                @endforeach
                                <td>
                                    <img src="{{ asset('uploads/images/ourworks/' . $work->photo) }}" width="150px" height="150px" alt="{{ __('main.work_photo') }}"> <!-- Added alt text -->
                                </td>
                                <td>
                                    <img src="{{ asset('uploads/images/ourworks/' . $work->icon) }}" width="150px" height="150px" alt="{{ __('main.work_icon') }}"> <!-- Added alt text -->
                                </td>
                                <td>{{ $work->link }}</td>
                                <td>
                                    <a href="{{ route('admin.our_works.edit', ['id' => $work->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }} <!-- Translated Edit -->
                                        </button>
                                    </a>

                                    @if($work->deleted_at == null)
                                        <a href="{{ route('admin.our_works.soft_delete', ['id' => $work->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button> <!-- Translated Soft Delete -->
                                        </a>
                                    @else
                                        <a href="{{ route('admin.our_works.restore', ['id' => $work->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button> <!-- Translated Restore -->
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.our_works.destroy', ['id' => $work->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button> <!-- Translated Remove -->
                                    </a>

                                    <a href="{{ route('admin.our_works.gallery', ['id' => $work->id]) }}">
                                        <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-edit"></i> {{ __('main.show_gallery') }}</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($langs) + 5 }}">{{ __('main.no_data') }}</td> <!-- Translated No Data -->
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $our_works->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
