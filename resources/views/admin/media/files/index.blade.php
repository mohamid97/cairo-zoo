@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.files') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.files') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.files.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_file') }}
                    </button>
                </a>
            </div>
            <br>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_files') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ __('main.file') }}</th>
                            @foreach($langs as $lang)
                                <th>{{ __('main.name') }} ({{ $lang->code }})</th>
                            @endforeach
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>
                                    <button class="btn btn-primary">
                                        <a target="_blank" style="color: #FFF" href="{{ asset('uploads/images/media/files/' . $file->file) }}">
                                            {{ __('main.show') }}
                                        </a>
                                    </button>
                                </td>
                                @foreach($langs as $lang)
                                    <td>{{ $file->translate($lang->code)->name }}</td>
                                @endforeach
                                <td>
                                    <a href="{{ route('admin.files.edit', ['id' => $file->id]) }}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}</button>
                                    </a>

                                    @if($file->deleted_at == null)
                                        <a href="{{ route('admin.files.soft_delete', ['id' => $file->id]) }}">
                                            <button class="btn btn-sm btn-warning"><i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.files.restore', ['id' => $file->id]) }}">
                                            <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}</button>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.files.destroy', ['id' => $file->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($langs) + 2 }}">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
