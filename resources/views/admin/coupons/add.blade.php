@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_coupon') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.coupons') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.coupons') }}</h3>
                </div>

                <form role="form" method="post" action="{{ route('admin.coupons.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label>{{ __('main.coupon_code') }}</label>
                            <input type="text" name="code" class="form-control" placeholder="{{ __('main.enter_coupon_code') }}" value="{{ old('code') }}">
                            @error('code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('main.discount_type') }}</label>
                                <select name="type" class="form-control" id="discount_type">
                                    <option value="percentage">{{ __('main.percentage') }}</option>
                                    <option value="fixed">{{ __('main.fixed_amount') }}</option>
                                </select>
                                @error('type')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('main.discount_value') }}</label>
                                <input type="number" step="1"  value="1" name="discount_value" class="form-control" value="{{ old('discount_value') }}">
                                @error('discount_value')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>



                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>{{ __('main.start_date') }}</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('main.end_date') }}</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('main.usage_limit') }}</label>
                                <input type="number" step="1"  value="1" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                                @error('usage_limit')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group form-check mb-3 col-md-6 d-flex  align-items-center pt-3 pl-4" >
                                <input type="checkbox" name="is_active" class="form-check-input" id="activeCheck" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck">{{ __('main.is_active') }}</label>
                                <br>
                                @error('is_active')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
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
