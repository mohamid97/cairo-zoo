@extends('admin.layout.master')

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

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{$expense->name}} </h3>
                </div>


                <form method="POST" action="{{ route('admin.expense.update' , ['id'=>$expense->id]) }}">
                    @csrf



                    <div class="card-body">


                        <br>

                        <div class="border p-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="amount">{{ __('main.amount') }}</label>
                                    <input id="amount" type="number" name="amount" step="0.01" class="form-control" placeholder="{{ __('main.amount') }}" value="{{isset($expense->latestAmount) ? $expense->latestAmount->amount : ''}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date">{{ __('main.date') }}</label>
                                    <input id="date" type="date" name="date" class="form-control"
                                           value="{{ isset($expense->latestAmount) ? \Carbon\Carbon::parse($expense->latestAmount->date)->format('Y-m-d') : '' }}">
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
