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
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.expense') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.expense') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="mb-3">
                <a href="{{ route('admin.expense.add') }}" class="btn btn-info">
                    <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_expense') }}
                </a>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.expense_list') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.type') }}</th>
                            <th>{{ __('main.amount') }}</th>
                            <th>{{ __('main.date') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($expenses as $index => $expense)
                            <tr data-toggle="collapse" data-target="#collapse{{ $expense->id }}" aria-expanded="false" style="cursor:pointer;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $expense->name }}</td>
                                <td>
                <span class="badge badge-{{ $expense->type == 'fixed' ? 'primary' : 'warning' }}">
                    {{ ucfirst($expense->type) }}
                </span>
                                </td>
                                <td>{{ $expense->latestAmountCurrentMonth ? $expense->latestAmountCurrentMonth->amount : '' }}</td>
                                <td>{{ $expense->latestAmountCurrentMonth ? $expense->latestAmountCurrentMonth->date : '' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.expense.edit', $expense->id) }}" class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" onclick="showDeleteExpenseModal({{ $expense->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="collapse{{ $expense->id }}" class="collapse">
                                <td colspan="6" class="text-left">
                                    <strong>All Expense Amounts:</strong>
                                    <table class="table table-sm table-bordered mt-2" style="background: #17a2b8;
    color: #FFF;">
                                        <thead>
                                        <tr>
                                            <th>{{ __('main.amount') }}</th>
                                            <th>{{ __('main.date') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($expense->expenseAmounts as $amount)
                                            <tr>
                                                <td>{{ $amount->amount ?? '-' }}</td>
                                                <td>{{ $amount->date }}</td>
                                            </tr>
                                        @endforeach
                                        @if($expense->expenseAmounts->isEmpty())
                                            <tr>
                                                <td colspan="2" class="text-center">No records found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>


                    <div class="d-flex justify-content-center mt-4">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteExpenseModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this expense?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteExpenseBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showDeleteExpenseModal(expenseId) {
            const url = `{{ url('admin/expense/delete') }}/${expenseId}`;
            document.getElementById('confirmDeleteExpenseBtn').setAttribute('href', url);
            $('#confirmDeleteExpenseModal').modal('show');
        }
    </script>
@endsection
