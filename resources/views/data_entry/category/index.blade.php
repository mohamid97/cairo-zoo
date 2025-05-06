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
                    <h1>{{ __('main.categories') }}</h1> <!-- Use translation key -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li> <!-- Use translation key -->
                        <li class="breadcrumb-item active">{{ __('main.categories') }}</li> <!-- Use translation key -->
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('data_entry.category.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_category') }} <!-- Use translation key -->
                    </button>
                </a>
            </div>
            <br>

            <!-- Search Form -->
            <form method="GET" action="{{ route('data_entry.category.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('main.search_by_name') }}"> <!-- Use translation key -->
                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit">
                            <i class="fas fa-search"></i> {{ __('main.search') }} <!-- Use translation key -->
                        </button>
                    </div>
                </div>
            </form>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_categories') }}</h3> <!-- Use translation key -->
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.photo') }}</th>
                            <th>{{ __('main.thumbinal') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.slug') }}</th>
                            <th>{{ __('main.type') }}</th>
                            <th>{{ __('main.parent') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $index => $cat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a target="_blank" href="{{ asset('uploads/images/category/' . $cat->photo) }}">
                                       <img src="{{ asset('uploads/images/category/' . $cat->photo) }}"width="40px" height="40px">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ asset('uploads/images/category/' . $cat->thumbinal) }}">
                                        <img src="{{ asset('uploads/images/category/' . $cat->thumbinal) }}"width="40px" height="40px">
                                    </a>
                                </td>
                                <td>{{ isset($cat->name) ? $cat->name : 'N/A' }}</td>
                                <td>{{ isset($cat->slug) ? $cat->slug : 'N/A' }}</td>

                                <td>
                                    @if($cat->type == 0)
                                        <span class="badge badge-danger">{{ __('main.parent') }}</span>
                                    @else
                                        <span class="badge badge-primary">{{ __('main.child') }}</span> <!-- Use translation key -->
                                    @endif
                                </td>
                                <td>{{($cat->parent) ? $cat->parent->name : null}}</td>
                                <td>

                                    <div class="d-flex align-items-center justify-content-center gap-2">

                                        <a href="{{ route('data_entry.category.edit', ['id' => $cat->id]) }}">
                                            <button class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-edit"></i>
                                            </button>
                                        </a>

{{--                                        <a href="{{ route('data_entry.category.destroy', ['id' => $cat->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-danger">--}}
{{--                                                <i class="nav-icon fas fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </a>--}}

                                        <button class="btn btn-sm btn-danger" onclick="showDeleteCategoryModal({{ $cat->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>

                                    </div>


{{--                                    @if($cat->deleted_at == null)--}}
{{--                                        <a href="{{ route('data_entry.category.soft_delete', ['id' => $cat->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info">--}}
{{--                                                <i class="nav-icon fas fa-trash"></i> {{ __('main.soft_delete') }} <!-- Use translation key -->--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{ route('data_entry.category.restore', ['id' => $cat->id]) }}">--}}
{{--                                            <button class="btn btn-sm btn-info">--}}
{{--                                                <i class="nav-icon fas fa-trash-restore"></i> {{ __('main.restore') }} <!-- Use translation key -->--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
{{--                                    @endif--}}


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $categories->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="confirmCategoryDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmCategoryDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_category_warning') ?? 'Are you sure you want to delete this Category? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteCategoryBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showDeleteCategoryModal(categoryId) {
            const url = `{{ url('data_entry/categories/destroy') }}/${categoryId}`;
            document.getElementById('confirmDeleteCategoryBtn').setAttribute('href', url);
            $('#confirmDeleteCategoryModal').modal('show');
        }
    </script>
@endsection
