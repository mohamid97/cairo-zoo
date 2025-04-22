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
                    <h1>{{ __('main.users') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.users') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.users.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_user') }}
                    </button>
                </a>
            </div>
            <br>

            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="input-group">
                        <input type="text" name="search" value="{{ $searchTerm }}" class="form-control" placeholder="{{ __('main.search_by_name') }}">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">
                                <i class="fas fa-search"></i> {{ __('main.search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_users') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.avatar') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.email') }}</th>
                            <th>{{ __('main.phone') }}</th>
                            <th>{{ __('main.type') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($accounts as $index => $account)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img class="img-circle" src="{{ asset('uploads/images/users/' . $account->avatar) }}" width="70px" height="70px" alt="{{ __('main.user_avatar') }}">
                                </td>
                                <td>{{ $account->first_name }} {{ $account->last_name }}</td>
                                <td>{{ $account->email }}</td>
                                <td>{{ $account->phone }}</td>
                                <td><span class="badge badge-primary">{{ $account->type }}</span> </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', ['id' => $account->id]) }}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i> {{ __('main.edit') }}
                                        </button>
                                    </a>

{{--                                    @if($account->deleted_at == null)--}}
{{--                                        <a href="{{ route('admin.users.soft_delete', ['id' => $account->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info">--}}
{{--                                                <i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }}--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{ route('admin.users.restore', ['id' => $account->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info">--}}
{{--                                                <i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }}--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
{{--                                @endif--}}

                                <!-- Remove with confirmation -->
                                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal({{ $account->id }})">
                                        <i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $accounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_user_warning') ?? 'Are you sure you want to delete this user? This will remove all related data.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showDeleteModal(userId) {
            const url = `{{ url('admin/users/destroy') }}/${userId}`;
            document.getElementById('confirmDeleteBtn').setAttribute('href', url);
            $('#confirmDeleteModal').modal('show');
        }
    </script>
@endsection
