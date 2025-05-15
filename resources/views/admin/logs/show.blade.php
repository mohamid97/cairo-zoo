@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.log_details') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.logs.index') }}">{{ __('main.logs') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.details') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.log_information') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">{{ __('main.user') }}</th>
                                        <td>{{ ($log->user->first_name) ? $log->user->first_name :'N/A'  }}  {{ ($log->user->last_name) ? $log->user->last_name :'N/A'  }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('main.action') }}</th>
                                        <td>
                                            <span class="badge bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'updated' ? 'info' : 'danger') }}">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('main.model') }}</th>
                                        <td>{{ $modelName }} (ID: {{ $log->model_id }})</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('main.date') }}</th>
                                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>{{ __('main.changes') }}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="30%">{{ __('main.field') }}</th>
                                            <th width="35%">{{ __('main.values') }}</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(is_array($changes))
                                            @foreach($changes as $field => $change)
                                                <tr>
                                                    <td>{{ $field }}</td>
                                                    <td>
                                                        @if(is_array($change))
                                                            {!! json_encode($change, JSON_PRETTY_PRINT) !!}
                                                        @else
                                                            {{ $change }}
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">{{ $changes }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-default">
                        <i class="fas fa-arrow-left"></i> {{ __('main.back') }}
                    </a>
                    <a href="{{ route('admin.logs.delete' , ['log'=>$log]) }}" class="btn btn-danger">
                        <i class="fas fa-trash"></i> {{ __('main.delete') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        .badge {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
    </style>
@endsection