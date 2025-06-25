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
        .gap-2 {
            gap: 10px;
        }
        /* Drag and Drop Styles */
        .draggable {
            cursor: move;
        }
        .dragging {
            opacity: 0.5;
            background-color: #f8f9fa;
        }
        .handle {
            cursor: move;
            width: 30px;
            text-align: center;
        }
        #saveOrderBtn {
            display: none;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.categories') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.categories') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.category.add') }}" style="color: #FFF">
                    <button class="btn btn-info">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_category') }}
                    </button>
                </a>
            </div>
            <br>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.category.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('main.search_by_name') }}">
                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit">
                            <i class="fas fa-search"></i> {{ __('main.search') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_categories') }}</h3>
                    <div class="card-tools">
                        <button id="saveOrderBtn" class="btn btn-sm btn-success">
                            <i class="fas fa-save"></i> {{ __('main.save_order') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="handle-col" style="width: 40px;"></th>
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
                        <tbody id="sortable">
                            @forelse($categories as $index => $cat)
                                <tr class="draggable" data-id="{{ $cat->id }}">
                                    <td class="handle">
                                        <i class="fas fa-arrows-alt"></i>
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a target="_blank" href="{{ asset('uploads/images/category/' . $cat->photo) }}">
                                           <img src="{{ asset('uploads/images/category/' . $cat->photo) }}" width="40px" height="40px">
                                        </a>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ asset('uploads/images/category/' . $cat->thumbinal) }}">
                                            <img src="{{ asset('uploads/images/category/' . $cat->thumbinal) }}" width="40px" height="40px">
                                        </a>
                                    </td>
                                    <td>{{ isset($cat->name) ? $cat->name : 'N/A' }}</td>
                                    <td>{{ isset($cat->slug) ? $cat->slug : 'N/A' }}</td>
                                    <td>
                                        @if($cat->type == 0)
                                            <span class="badge badge-danger">{{ __('main.parent') }}</span>
                                        @else
                                            <span class="badge badge-primary">{{ __('main.child') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ ($cat->parent) ? $cat->parent->name : null }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('admin.category.edit', ['id' => $cat->id]) }}">
                                                <button class="btn btn-sm btn-info">
                                                    <i class="nav-icon fas fa-edit"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="showDeleteCategoryModal({{ $cat->id }})">
                                                <i class="nav-icon fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">{{ __('main.no_data') }}</td>
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
    <!-- Add required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.css">

    <script>
        function showDeleteCategoryModal(categoryId) {
            const url = `{{ url('admin/categories/destroy') }}/${categoryId}`;
            document.getElementById('confirmDeleteCategoryBtn').setAttribute('href', url);
            $('#confirmDeleteCategoryModal').modal('show');
        }

        $(document).ready(function() {
            // Initially hide the save button
            $('#saveOrderBtn').hide();

            // Initialize sortable
            new Sortable(document.getElementById('sortable'), {
                handle: '.handle',
                animation: 150,
                ghostClass: 'dragging',
                onUpdate: function() {
                    $('#saveOrderBtn').show();
                }
            });

            // Save order button click handler
            $('#saveOrderBtn').click(function() {
                const order = [];
                $('#sortable tr').each(function(index) {
                    order.push({
                        id: $(this).data('id'),
                        order: index + 1
                    });
                });

                $.ajax({
                    url: '{{ route("admin.category.updateOrder") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    beforeSend: function() {
                        $('#saveOrderBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ __("main.order_saved") }}');
                            // Update the position numbers
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:eq(1)').text(index + 1);
                            });
                        } else {
                            toastr.error('{{ __("main.error_saving_order") }}');
                        }
                    },
                    error: function() {
                        toastr.error('{{ __("main.error_saving_order") }}');
                    },
                    complete: function() {
                        $('#saveOrderBtn').hide().prop('disabled', false).html('<i class="fas fa-save"></i> {{ __("main.save_order") }}');
                    }
                });
            });
        });
    </script>
@endsection