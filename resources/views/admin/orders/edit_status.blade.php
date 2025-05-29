@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>@lang('main.edit_order')</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <p class="badge badge-danger text-center w-100"> {{__('main.carful_update_order')}}</p>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">@lang('main.status')</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status">@lang('main.order_status')</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                            <option value="procced" {{ $order->status == 'procced' ? 'selected' : '' }}>@lang('Proceed')</option>
                            <option value="on-way" {{ $order->status == 'on-way' ? 'selected' : '' }}>@lang('On Way')</option>
                            <option value="finshed" {{ $order->status == 'finshed' ? 'selected' : '' }}>@lang('Finished')</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>@lang('Canceled')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_status">@lang('main.payment_status')</label>
                        <select class="form-control" id="payment_status" name="payment_status">
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>@lang('Paid')</option>
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>@lang('Unpaid')</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">@lang('main.update')</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
