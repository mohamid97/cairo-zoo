@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('main.dashboard') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Can Grow</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $users }}</h3>
                            <p>{{ __('main.users') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $products }}</h3>
                            <p>{{ __('main.products') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $services }}</h3>
                            <p>{{ __('main.services') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.services.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $categories }}</h3>
                            <p>{{ __('main.categories') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('admin.category.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $blogs }}</h3>
                            <p>{{ __('main.blogs') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.cms.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $langs }}</h3>
                            <p>{{ __('main.langs') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.lang.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $media_group }}</h3>
                            <p>{{ __('main.media_group') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.group_media.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $sliders }}</h3>
                            <p>{{ __('main.sliders') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('admin.sliders.index') }}" class="small-box-footer">{{ __('main.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('main.carts') }}</span>
                            <span class="info-box-number">{{ $cards }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('main.orders') }}</span>
                            <span class="info-box-number">{{ $orders }}</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-percent"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('main.offers') }}</span>
                            <span class="info-box-number">{{ $offers }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('main.points') }}</span>
                            <span class="info-box-number">{{ $totalPoints }}</span>
                        </div>
                    </div>
                </div>
            </div>






            <div class="row">
                <div class="card col-md-12">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"> {{ __('main.latest_orders') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th> ID</th>
                                    <th>{{ __('main.name') }}</th>
                                    <th>{{ __('main.status') }}</th>
                                    <th>{{ __('main.total_price') }}</th>
                                    <th>{{ __('main.shiping_price') }}</th>
                                    <th>{{ __('main.shiping_price') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($latest_orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show_details', $order->id) }}">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td>
                                    <span
                                        class="badge badge-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'finished' ? 'success' : 'info') }}"
                                        title="{{ ucfirst($order->status) }} Order"
                                    >
                                        {{ ucfirst($order->status) }}
                                    </span>
                                        </td>
                                        <td>${{ number_format($order->total_price, 2) }}</td>
                                        <td>${{ number_format($order->shipment_price, 2) }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No latest orders available.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary float-right">{{ __('main.all_orders') }}</a>
                    </div>
                </div>
            </div>


            <div class="row">
            <div class="card col-md-12">
                <div class="card-header border-transparent">
                    <h3 class="card-title">  {{ __('main.latest_cards') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> {{ __('main.name') }}</th>
                                <th> {{ __('main.items') }}</th>
                                <th>{{ __('main.total_price') }}</th>
                                <th>{{ __('main.date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latest_cards as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>{{ $card->user->first_name ?? 'N/A' }}</td>
                                    <td>
                                        @foreach($card->items as $item)
                                            <div>
                                                <strong>{{ $item->product->name }}</strong> (x{{ $item->quantity }})
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>${{ number_format($card->total_price, 2) }}</td>

                                    <td>{{ $card->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <a href="{{ route('admin.cards.index') }}" class="btn btn-sm btn-secondary float-right"> {{ __('main.all_carts') }}  </a>

                </div>
            </div>
        </div>
            <div class="row">
                <div class="card col-md-12">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"> {{ __('main.lowest_product') }} </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th> ID</th>
                                        <th>{{ __('main.name') }} </th>
                                        <th>{{ __('main.stock') }} </th>
                                        <th>{{ __('main.date') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowest_stock as $pro)
                                    <tr>
                                        <td><a href="{{ route('admin.products.edit', $pro->id) }}">{{ $pro->id }} </a></td>
                                        <td>{{ $pro->name ?? 'N/A' }}</td>

                                        <td>{{ $pro->stock }}</td>

                                        <td>{{ $pro->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary float-right">{{ __('main.all_products') }} </a>

                    </div>
                </div>
            </div>




<br><br>


                <!-- Order Status Chart -->
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="orderChart"></canvas>
                    </div>

                    <div class="col-md-6">
                        <canvas id="categoryProductChart"></canvas>
                    </div>
                </div>

                <br><br>
                <hr>
                <!-- Product Stock Chart -->
                <div class="row"  style="    margin: 50px 0 80px 0;padding: 0 0 50px;">

                    <div class="col-md-6">
                        <canvas id="orderUserStatusChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="salesLineChart"></canvas>
                    </div>

                </div>
<hr>
<br>
                <div class="col-md-12">
                    <canvas id="productStockChart"></canvas>
                </div>



        </div><!-- /.container-fluid -->



    </section>
    <!-- /.content -->



@endsection


@section('scripts')




<script>
    document.addEventListener('DOMContentLoaded', function() {



    // Data for the chart
    var salesData = @json($salesData);
    var currentMonth = @json($currentMonth);
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    // Slice months array to include only up to the current month
    var displayedMonths = months.slice(0, currentMonth);

    // Options for the chart
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Months'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Sales ($)'
                },
                beginAtZero: true
            }
        }
    };

    // Create the chart
    var ctx = document.getElementById('salesLineChart').getContext('2d');
    var salesLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: displayedMonths,
            datasets: [{
                label: 'Monthly Sales',
                data: salesData,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: options
    });







        // Category Product Count Chart
const categoryProductCtx = document.getElementById('categoryProductChart').getContext('2d');
const categoryProductChart = new Chart(categoryProductCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($categoryProductCounts)) !!}, // Category names
        datasets: [{
            label: 'Number of Products',
            data: {!! json_encode(array_values($categoryProductCounts)) !!}, // Product counts
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Products'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Category Name'
                }
            }
        },
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Number of Products per Category'
            }
        }
    }
});





// Order Status Chart
const orderStatusCtx = document.getElementById('orderChart').getContext('2d');
const orderStatusChart = new Chart(orderStatusCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($orderStatusCounts)) !!}, // All statuses
        datasets: [{
            label: 'Orders by Status',
            data: {!! json_encode(array_values($orderStatusCounts)) !!}, // Corresponding counts
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Orders'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Order Status'
                }
            }
        },
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Orders by Status'
            }
        }
    }
});



            // Data for the chart
     var orderData = {
        labels: ['Users with Orders', 'Users without Orders'],
        datasets: [{
            data: [{{ $usersWithOrders }}, {{ $usersWithoutOrders }}], // Replace these variables with your actual data
            backgroundColor: ['#36A2EB', '#FF6384'],
            hoverBackgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    // Options for the chart
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        var total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                        var value = tooltipItem.raw;
                        var percentage = ((value / total) * 100).toFixed(2);
                        return tooltipItem.label + ': ' + percentage + '%';
                    }
                }
            }
        }
    };

    // Create the chart
    var ctx = document.getElementById('orderUserStatusChart').getContext('2d');
    var orderUserStatusChart = new Chart(ctx, {
        type: 'doughnut', // Use 'pie' for a pie chart
        data: orderData,
        options: options
    });






    // Product Stock Chart
const productStockCtx = document.getElementById('productStockChart').getContext('2d');
const productStockChart = new Chart(productStockCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($productsStockCounts)) !!}, // Product names
        datasets: [{
            label: 'Product Stock',
            data: {!! json_encode(array_values($productsStockCounts)) !!}, // Stock counts
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Stock Quantity'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Product Name'
                }
            }
        },
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Product Stock Levels'
            }
        }
    }
});




    });
</script>

@endsection
