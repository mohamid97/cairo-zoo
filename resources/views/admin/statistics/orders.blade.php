@extends('admin.layout.master')


@section('content')

    <section class="content-header">
        <div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Date Filter</h3>
            <form method="GET" class="form-inline float-right">
                <div class="input-group input-group-sm">
                    <input type="date" class="form-control" name="start_date" value="{{ $start_date }}">
                    <div class="input-group-append">
                        <span class="input-group-text">to</span>
                    </div>
                    <input type="date" class="form-control" name="end_date" value="{{ $end_date }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div>
    </section>


    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Online Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Online Orders</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tr>

                            <th>Total Orders</th>
                            <td>{{ $online_orders->total_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->total_revenue ?? 0, 2) }}</td>

                        </tr>

                        <tr>
                            <th>Shipment Fees</th>
                            <td> -- </td>
                            <td>{{ number_format($online_orders->total_shipment ?? 0, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Completed Orders</th>
                            <td>{{ $online_orders->finshed_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->completed_revenue ?? 0, 2) }}</td>

                        </tr>


                        <tr>
                            <th>Canceled Orders</th>
                            <td>{{ $online_orders->canceled_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->canceled_revenue ?? 0, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Pending Orders</th>
                            <td>{{ $online_orders->pending_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->pending_revenue ?? 0, 2) }}</td>
                        </tr>


                        <tr>
                            <th>On Way  Orders</th>
                            <td>{{ $online_orders->on_way_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->on_way_revenue ?? 0, 2) }}</td>
                        </tr>



                        <tr>
                            <th>Processing  Orders</th>
                            <td>{{ $online_orders->processing_orders ?? 0 }}</td>
                            <td>{{ $online_orders->procced_revenue ?? 0 }}</td>
                        </tr>


                        <tr>
                            <th>Retrieval Orders</th>
                            <td>{{ $online_orders->retrieval_orders ?? 0 }}</td>
                            <td>{{ number_format($online_orders->retrieval_revenue ?? 0, 2) }}</td>
                        </tr>



                    </table>
                </div>
            </div>
        </div>

        <!-- Cashier Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">Cashier Orders</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tr>
                            <th>Total Orders</th>
                            <td>{{ $cashier_orders->total_orders ?? 0 }}</td>
                            <td>{{ number_format($cashier_orders->total_revenue ?? 0, 2) }}</td>

                        </tr>

                        <tr>
                            <th>Completed Orders Revenue</th>
                            <td>{{ $cashier_orders->completed_orders ?? 0 }}</td>
                            <td>{{ number_format($cashier_orders->completed_revenue ?? 0, 2) }}</td>


                        </tr>

                        <tr>
                            <th>Cancel Orders Revenue</th>
                            <td>{{ $cashier_orders->canceled_orders ?? 0 }}</td>
                            <td>{{ number_format($cashier_orders->canceled_revenue ?? 0, 2) }}</td>


                        </tr>



                        <tr>
                            <th>Retrieval Orders</th>
                            <td>{{ $cashier_orders->retrieval_orders ?? 0 }}</td>
                            <td>{{ number_format($cashier_orders->retrieval_revenue ?? 0, 2) }}</td>

                        </tr>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">Difference Orders</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">

                        <thead>
                        <tr>

                            <th>Complete Order</th>
                            <th>Difference</th>
                            <th>Shipment</th>
                        </tr>
                        </thead>
                        <tr>
                            <th>{{ number_format($combined_stats['total_complete'], 2) }}</th>
                            <td>{{ number_format($online_orders->diff  + $cashier_orders->diff , 2) }}</td>
                            <td>{{ number_format($online_orders->total_shipment_complete , 2) }}</td>

                        </tr>


                    </table>
                </div>
            </div>


        </div>
    </div>

    <!-- Combined Stats -->
    <div class="card mt-4">
        <div class="card-header bg-purple">
            <h3 class="card-title">Combined Statistics</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Orders</span>
                            <span class="info-box-number">{{ $combined_stats['total_orders'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-secondary">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Revenue</span>
                            <span class="info-box-number">{{ number_format($combined_stats['total_revenue'], 2) }}</span>
                        </div>
                    </div>
                </div>



                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Complete</span>
                            <span class="info-box-number">{{ number_format($combined_stats['total_complete'], 2) }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-danger">
                        <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Canceled Revenue</span>
                            <span class="info-box-number">{{ number_format($online_orders->canceled_revenue, 2) }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-teal">
                        <span class="info-box-icon"><i class="fas fa-undo"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retrieval Revenue</span>
                            <span class="info-box-number">{{ number_format($combined_stats['retrieval_revenue'], 2) }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-warning">
                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Revenue</span>
                            <span class="info-box-number">{{ number_format($online_orders->pending_revenue, 2) }}</span>
                        </div>
                    </div>
                </div>



                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-gradient-primary">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Proceed Revenue</span>
                            <span class="info-box-number">{{ number_format($online_orders->procced_revenue, 2) }}</span>
                        </div>
                    </div>
                </div>



                <div class="col-md-3 col-sm-6">
                    <div class="info-box  bg-gradient-gradient	">
                        <span class="info-box-icon"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">On Way  Revenue</span>
                            <span class="info-box-number">{{ number_format($online_orders->on_way_revenue, 2) }}</span>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

        </div>
    </section>
@endsection
