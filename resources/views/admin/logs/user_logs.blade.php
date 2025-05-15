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
        .gap-2{
            gap: 10px;
        }
        .json-data {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .json-data:hover {
            white-space: normal;
            overflow: visible;
            word-break: break-all;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.logs') }} - {{($logs[0]) ? $logs[0]->user->first_name : 'N/A'}}  {{$logs[0] ? $logs[0]->user->last_name : 'N/A' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.logs') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.activity_logs') }}</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.logs.index') }}" method="GET">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="{{ __('main.search') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.user') }}</th>
                            <th>{{ __('main.action') }}</th>
                            <th>{{ __('main.model') }}</th>
                            <th>{{ __('main.changes') }}</th>
                            <th>{{ __('main.date') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>
                                 <a href="{{ route('admin.logs.users.show', ['user' => $log->user]) }}">
                                    <span class="badge bg-info">
                                        {{ ($log->user->first_name) ? $log->user->first_name :'N/A'  }}  {{ ($log->user->last_name) ? $log->user->last_name :'N/A'  }}
                                    </span>
                                 </a>
                                
                                </td>
                                <td>{{ $log->action }}</td>
                                <td>
                                    {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                </td>
                                <td class="json-data" title="{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}">
                                    @if(is_array($log->changes))
                                        {{ json_encode($log->changes) }}
                                    @else
                                        {{ $log->changes }}
                                    @endif
                                </td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>

                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.logs.show', ['log' => $log]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

    @section('scripts')
        <script>
            // Tooltip for JSON data
            $(function () {
                $('[title]').tooltip();
            });
        </script>
    @endsection