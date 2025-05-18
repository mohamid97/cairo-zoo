@extends('data_entry.layout.master')

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
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.tastes') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.tastes') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('data_entry.tastes.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_taste') }}
                    </button>
                </a>
            </div>
            <br>

            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('data_entry.tastes.index') }}" class="input-group">
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
                    <h3 class="card-title">{{ __('main.tastes') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.image') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.slug') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tastes as $index => $taste)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ asset('uploads/images/taste/' . $taste->image) }}" target="_blank">
                                        <img class="img-circle" src="{{ asset('uploads/images/taste/' . $taste->image) }}" width="40px" height="40px" alt="{{ __('main.taste') }}">
                                    </a>

                                </td>
                                <td>{{ $taste->name }}</td>
                                <td>{{ $taste->slug }}</td>

                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('data_entry.tastes.edit', ['id' => $taste->id]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-edit"></i>
                                            </button>
                                        </a>

                                        <!-- Delete With Confirmation -->
                                        <button class="btn btn-sm btn-danger" onclick="showDeleteTasteModal({{ $taste->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>
                                    </div>

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
                        {{ $tastes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteTasteModal" tabindex="-1" role="dialog" aria-labelledby="confirmTasteDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmTasteDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_taste_warning') ?? 'Are you sure you want to delete this Taste? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteTasteBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showDeleteTasteModal(tasteId) {
            const url = `{{ url('data_entry/tastes/delete') }}/${tasteId}`;
            document.getElementById('confirmDeleteTasteBtn').setAttribute('href', url);
            $('#confirmDeleteTasteModal').modal('show');
        }
    </script>
@endsection
