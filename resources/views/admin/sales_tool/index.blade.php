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
    </style>


@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.sales_tool') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.sales_tool') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
          <Br><br>

            <h3>{{ __('main.quartars_and_months') }}</h3>

            <div class="row">
                <div class="col-md-6">
                    <canvas id="quarterlyChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>




            <br><br><Br><br>
            <hr>
            <br><br><Br><br>

                <h3>{{ __('main.quartars_and_months') }}</h3>



            <div class="row">
                <div class="col-md-6">
                    <label for="monthSelect">Select Months:</label>
                    <select id="monthSelect" class="form-control" multiple>
                        <option value="all">All</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>

                </div>
                <div class="col-md-6">
                    <label for="productSelect">Select Products:</label>
                    <select id="productSelect" class="form-control" multiple>
                        <option value="all">All</option>
                        <!-- Loop through products from database -->
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Graph area -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>



            <br><Br><Br><Br>
            <hr>
            <br><br><br><br>

            <!-- Product Comparison Section -->
{{--            <h3>{{ __('main.product_comparison') }}</h3>--}}
{{--            <br><Br>--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <label for="productscompare">Select Products:</label>--}}
{{--                    <select id="productscompare" class="form-control" multiple>--}}
{{--                        <option value="all">All Products</option>--}}
{{--                        <!-- Loop through products from database -->--}}
{{--                        @foreach ($products as $product)--}}
{{--                            <option value="{{ $product->id }}">{{ $product->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Graph area -->--}}
{{--            <div class="row mt-4">--}}
{{--                <div class="col-md-12">--}}
{{--                    <canvas id="productComparisonChart"></canvas>--}}
{{--                </div>--}}
{{--            </div>--}}







        </div>
    </section>
@endsection

@section('scripts')


@section('scripts')

    <script>
        $(document).ready(function() {
            // Initialize Select2 with placeholder and allowClear options
            $('#productSelect').select2({
                placeholder: "Select products",
                allowClear: true
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const productComparisonChart = new Chart(document.getElementById('productComparisonChart'), {
                type: 'bar',
                data: {
                    labels: [],  // Will be populated dynamically
                    datasets: [{
                        label: 'Total Sales per Product',
                        data: [],  // Will be populated dynamically
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            function updateChart(data) {
                productComparisonChart.data.labels = data.map(item => item.product_name);
                productComparisonChart.data.datasets[0].data = data.map(item => item.total_sales);
                productComparisonChart.update();
            }

            function fetchData() {
                const products = Array.from(document.getElementById('productscompare').selectedOptions).map(opt => opt.value);

                fetch('{{ route("admin.sales_tool.products_comparison") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ products })
                })
                    .then(response => response.json())
                    .then(data => {
                        updateChart(data)
                    });
            }

            document.getElementById('productscompare').addEventListener('change', fetchData);
        });
    </script>






    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quarterlyData = @json($quarterlyOrders->pluck('total_sales'));
            const quarterlyLabels = ['Q1', 'Q2', 'Q3', 'Q4'];

            const monthlyData = @json($monthlyOrders->pluck('total_sales'));
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Quarterly Chart
            new Chart(document.getElementById('quarterlyChart'), {
                type: 'bar',
                data: {
                    labels: quarterlyLabels,
                    datasets: [{
                        label: 'Total Sales per Quarter',
                        data: quarterlyData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Monthly Chart
            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Total Sales per Month',
                        data: monthlyData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const comparisonChart = new Chart(document.getElementById('comparisonChart'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Sales',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            function updateChart(data) {
                comparisonChart.data.labels = data.map(item => 'Month ' + item.month);
                comparisonChart.data.datasets[0].data = data.map(item => item.total_sales);
                comparisonChart.update();
            }

            function fetchData() {

                const months = Array.from(document.getElementById('monthSelect').selectedOptions).map(opt => opt.value);
                const products = Array.from(document.getElementById('productSelect').selectedOptions).map(opt => opt.value);

                fetch('{{ route("admin.sales_tool.order_comparison") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ months, products })
                })
                    .then(response => response.json())
                    .then(data => updateChart(data));
            }

            document.getElementById('monthSelect').addEventListener('change', fetchData);
            document.getElementById('productSelect').addEventListener('change', fetchData);
        });
    </script>




@endsection
