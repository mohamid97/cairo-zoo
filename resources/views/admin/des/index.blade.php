@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.des') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.des') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.des.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_description') }}
                    </button>
                </a>
            </div>
            <br>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_descriptions') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.des') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($des as $de)
                            <tr>
                                <td>{{ $de->id }}</td>
                                <td>{{ $de->translate($langs[0]->code)->name }}</td>
                                <td>{!! $de->translate($langs[0]->code)->des !!}</td>
                                <td>
                                    <a href="{{ route('admin.des.edit', ['id' => $de->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}
                                        </button>
                                    </a>

                                    @if(is_null($de->deleted_at))
                                        <a href="{{ route('admin.des.soft_delete', ['id' => $de->id]) }}">
                                            <button class="btn btn-sm btn-warning">
                                                <i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.des.restore', ['id' => $de->id]) }}">
                                            <button class="btn btn-sm btn-success">
                                                <i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}
                                            </button>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.des.destroy', ['id' => $de->id]) }}">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
