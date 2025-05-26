@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_expense') }}</h1>
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

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.add_expense') }}</h3>
                </div>

                <form method="POST" action="{{ route('admin.expense.store') }}">
                    @csrf



                    <div class="card-body">
                        <div class="border p-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('main.name') }}</label>
                                    <input id="name" type="text" name="name" class="form-control" placeholder="{{ __('main.name') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{ __('main.type') }}</label>
                                    <select name="type" class="form-control" required>
                                        <option value="fixed">{{ __('main.fixed') }}</option>
                                        <option value="variable">{{ __('main.variable') }}</option>
                                    </select>
                                </div>


                             </div>
                        </div>

                        <br>

                        <div class="border p-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="amount">{{ __('main.amount') }}</label>
                                    <input id="amount" type="number" name="amount" step="0.01" class="form-control" placeholder="{{ __('main.amount') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date">{{ __('main.date') }}</label>
                                    <input id="date" type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>

                            </div>
                        </div>






                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.add') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
