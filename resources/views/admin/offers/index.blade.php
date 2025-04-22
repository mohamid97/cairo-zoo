@extends('admin.layout.master')

@section('styles')
<style>
    svg{
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
                <h1>Offers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Offers</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div>
            <a href="{{ route('admin.offers.add') }}" style="color: #FFF">
                <button class="btn btn-info">
                    <i class="nav-icon fas fa-plus"></i> Add New Offers
                </button>
            </a>
        </div>
        <br>
        <form method="GET" action="{{ route('admin.offers.index') }}" class="mb-3">
            <div class="input-group">
                <select name="product_id" class="form-control">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request()->get('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button class="btn btn-info" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">All Offers</h3>
                <div class="card-tools">

                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <form method="GET" action="{{ route('admin.offers.index') }}">
                            <select name="sort" onchange="this.form.submit()" class="form-control">
                                <option value="">Sort By</option>
                                <option value="latest" {{ request()->get('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request()->get('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </form>
                    </div>
                </div>
                <br>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($offers as $index=>$offer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $offer->product->name }}</td>
                            <td>
                                <a href="{{ route('admin.offers.delete', ['id' => $offer->id]) }}">
                                    <button class="btn btn-sm btn-danger">
                                        <i class="nav-icon fas fa-trash"></i> Remove
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No Data</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
