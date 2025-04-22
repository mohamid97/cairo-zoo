@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.backup') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.backup') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">





            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.backup') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.files') }}</th>
                            <th>{{ __('main.database') }}</th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>#</td>
                            <td>
                                <a href="{{route('admin.backup.folder')}}">
                                    <button class="btn btn-sm btn-primary"><i class="nav-icon fas fa-database"></i> {{ __('main.backup_file') }}</button>
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.backup.database') }}">
                                    <button class="btn btn-sm btn-primary"><i class="nav-icon fas fa-database"></i> {{ __('main.backup_database') }}</button>
                                </a>
                            </td>



                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
