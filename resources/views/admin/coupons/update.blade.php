@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.edit_coupon') }}</h1>
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
            <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
                @csrf
                @method('POST')

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('main.edit_coupon') }}</h3>
                    </div>

                    <div class="card-body">

                        <div class="border p-3">
                            <div class="form-group">
                                <label>{{ __('main.code') }}</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}">
                                @error('code') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <br>


                        <div class="border p-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>{{ __('main.type') }}</label>
                                    <select name="type" class="form-control">
                                        <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                    @error('type') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group  col-md-6">
                                    <label>{{ __('main.discount_value') }}</label>
                                    <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value', $coupon->discount_value) }}">
                                    @error('discount_value') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>
                        <br>

                        <div class="border p-3">
                            <div class="row">


                                <div class="form-group col-md-6">
                                    <label>{{ __('main.start_date') }}</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date) }}">
                                    @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{ __('main.end_date') }}</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date) }}">
                                    @error('end_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>

                        <br>
                        <div class="border p-3">

                          <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.usage_limit') }}</label>
                                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                                    @error('usage_limit') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-check mt-3 col-md-6 d-flex  align-items-center  pl-4">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="activeCheck" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="activeCheck">{{ __('main.is_active') }}</label>
                                    <br>
                                    @error('is_active') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                          </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-edit"></i>
                            {{ __('main.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
