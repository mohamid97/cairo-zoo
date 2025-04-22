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
                    <h1>{{ __('main.blog') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.blog') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('admin.cms.add') }}" style="color: #FFF">
                        <button class="btn btn-info">
                            <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_blog') }}
                        </button>
                    </a>
                </div>
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.cms.index') }}" class="mb-3">
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
                    <h3 class="card-title">{{ __('main.all_articles') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.image') }}</th>
                            <th>{{ __('main.title') }}</th>
                            <th>{{ __('main.slug') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cms as $index => $blog)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('uploads/images/cms/'. $blog->image) }}" width="150px" height="150px">
                                </td>
                                <td>{{ $blog->translate(app()->getLocale())->name }}</td>
                                <td>{{ $blog->translate(app()->getLocale())->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.cms.edit', ['id' => $blog->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button>
                                    </a>
                                    @if($blog->deleted_at == null)
                                        <a href="{{ route('admin.cms.soft_delete', ['id' => $blog->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.cms.restore', ['id' => $blog->id]) }}">
                                            <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.cms.destroy', ['id' => $blog->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        <!-- Pagination Links -->
                        {{ $cms->links() }}
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
