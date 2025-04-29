@extends('admin.layout.master')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endsection
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.discounts') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.discounts') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.brands') }} </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('admin.discounts.store') }}">
                @csrf

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('main.add_discount') }}</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>{{ __('main.type') }}</label>
                            <select name="type" class="form-control" id="discountType" required >
                                <option value="global">Global</option>
                                <option value="brand">Brand</option>
                                <option value="category">Category</option>
                                <option value="product">Product</option>
                            </select>
                        </div>

                        <div class="form-group" id="targetSelect" style="display: none;">
                            <label>{{ __('main.target') }}</label>
                            <select name="target_id" id="target_id" class="form-control select2-search">
                                <option value="">{{ __('main.choose_target') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('main.discount_type') }}</label>
                            <select name="percentage" class="form-control" id="percentageType">
                                <option value="YES">{{ __('main.percentage') }}</option>
                                <option value="NO">{{ __('main.amount') }}</option>
                            </select>
                        </div>

                        <div class="form-group" id="percentageInput">
                            <label>{{ __('main.discount_percentage') }} %</label>
                            <input type="number" name="discount_value" step=".5" min="1" class="form-control" required value="1">
                        </div>

                        <div class="form-group" id="amountInput" style="display: none;">
                            <label>{{ __('main.discount_amount') }} </label>
                            <input type="number" name="discount_value" step=".5" min="1" class="form-control" required value="1">
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-search').select2({
                placeholder: "{{ __('main.search_product') }}",
                allowClear: true,
                minimumInputLength: 2,
                width: '100%'
            });
        });
    </script>
    <script>


        const discountType = document.getElementById('discountType');
        const targetSelect = document.getElementById('targetSelect');
        const targetId = document.getElementById('target_id');

        discountType.addEventListener('change', function () {
            if (this.value === 'global') {
                targetSelect.style.display = 'none';
                targetId.innerHTML = '';
                return;
            }

            targetSelect.style.display = 'block';
            targetId.innerHTML = '<option value="">{{ __('main.loading') }}</option>';

            fetch(`/admin/discounts/targets/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    targetId.innerHTML = '<option value="">{{ __('main.choose_target') }}</option>';
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        targetId.appendChild(opt);
                    });
                });
        });

        const percentageType = document.getElementById('percentageType');
        const percentageInput = document.getElementById('percentageInput');
        const amountInput = document.getElementById('amountInput');

        percentageType.addEventListener('change', function () {
            if (this.value == 'YES') {
                percentageInput.style.display = 'block';
                amountInput.style.display = 'none';
            } else {
                percentageInput.style.display = 'none';
                amountInput.style.display = 'block';
            }
        });
    </script>
@endsection
