@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('main.tags')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('main.home')</a></li>
                        <li class="breadcrumb-item active">@lang('main.tags')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.tags.create') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> @lang('main.add_new_tag')
                    </button>
                </a>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.tags.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="@lang('main.search_by_name')" aria-label="@lang('main.search_by_name')">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">
                                <i class="fas fa-search"></i> @lang('main.search')
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('main.all_tags')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            @foreach($langs as $lang)
                                <th>@lang('main.name') ({{$lang->code}})</th>
                            @endforeach
                            <th>@lang('main.date')</th>
                            <th>@lang('main.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tags as $index => $tag)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                @foreach($langs as $lang)
                                    <td>{{ isset($tag->translate($lang->code)->name) ? $tag->translate($lang->code)->name : '' }}</td>
                                @endforeach
                                <td>{{ $tag->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.tags.edit', ['id' => $tag->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> @lang('main.edit')</button>
                                    </a>

                                    <a href="{{ route('admin.tags.delete', ['id' => $tag->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> @lang('main.remove')</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($langs) + 3 }}">@lang('main.no_data')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
