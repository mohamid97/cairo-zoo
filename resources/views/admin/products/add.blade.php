@extends('admin.layout.master')

@section('content')





    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.add_products') }}</h1> <!-- Translated Title -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.add_product') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.products') }}</h3> <!-- Translated Header -->
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="border p-3">
                        <div class="row">

                        @foreach($langs as $lang)
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label> <!-- Translated Label -->
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="{{ __('main.enter_name') }}" value="{{ old('name.' . $lang->code) }}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        </div>
                        </div>

                        <br>
                        <div class="border p-3">
                            <div class="row">
                            @foreach($langs as $lang)
                                <div class="form-group col-md-6">
                                    <label for="slug">{{ __('main.slug') }} ({{ $lang->name }}) </label> <!-- Translated Label -->
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="{{ __('main.enter_slug') }}" value="{{ old('slug.' . $lang->code) }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="border p-3">
                            <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="price">{{ __('main.sales_price') }}</label>
                                        <input type="number" name="sales_price" class="form-control" id="price" placeholder="{{ __('main.enter_sales_price') }}" value="{{ old('sales_price') }}">
                                        @error('sales_price')
                                        <div class="text-danger">{{ $errors->first('sales_price') }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sku">{{ __('main.sku') }}</label>
                                        <input type="text" name="sku" class="form-control" id="sku" placeholder="{{ __('main.enter_sku') }}" value="{{ old('sku') }}">
                                        @error('sku')
                                        <div class="text-danger">{{ $errors->first('sku') }}</div>
                                        @enderror
                                    </div>

                                <div class="form-group col-md-3">
                                    <label for="video">{{ __('main.video') }}</label>
                                    <input type="url" name="video" class="form-control" id="video" placeholder="{{ __('main.enter_video') }}" value="{{ old('video') }}">
                                    @error('video')
                                    <div class="text-danger">{{ $errors->first('video') }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="barcode">{{ __('main.barcode') }}</label>
                                    <input type="text" name="barcode" class="form-control" id="barcode" placeholder="{{ __('main.enter_barcode') }}" value="{{ old('barcode') }}">
                                    @error('barcode')
                                    <div class="text-danger">{{ $errors->first('barcode') }}</div>
                                    @enderror
                                </div>


                            </div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="old_price">{{ __('main.old_price') }}</label> <!-- Translated Label -->--}}
{{--                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="{{ __('main.enter_old_price') }}" value="{{ old('old_price') }}">--}}
{{--                            @error('old_price')--}}
{{--                            <div class="text-danger">{{ $errors->first('old_price') }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="discount">{{ __('main.discount') }}</label> <!-- Translated Label -->--}}
{{--                            <input type="text" name="discount" class="form-control" id="discount" placeholder="{{ __('main.enter_discount') }}" value="{{ old('discount') }}">--}}
{{--                            @error('discount')--}}
{{--                            <div class="text-danger">{{ $errors->first('discount') }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}



                        <br>
                        <div class="border p-3">

                            <div class="row">
                                @foreach($langs as $index => $lang)
                                    <div class="form-group col-md-6">
                                        <label for="small_des">{{ __('main.small_des') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                        <textarea class="form-control" name="small_des[{{$lang->code}}]" >{{ old('small_des.' . $lang->code) }}</textarea>
                                        @error('small_des.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                        </div>





<br>
                        <div class="border p-3">
                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="description">{{ __('main.des') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">{{ old('des.' . $lang->code) }}</textarea>
                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        </div>
                        <br>
                        <div class="border p-3">
                            <div class="row">
                                    @foreach($langs as $index => $lang)
                                        <div class="form-group col-md-6">
                                            <label for="meta_title">{{ __('main.meta_title') }} ({{$lang->name}})</label>
                                            <textarea class="form-control" name="meta_title[{{$lang->code}}]" >{{ old('meta_title.' . $lang->code) }}</textarea>
                                            @error('meta_title.' . $lang->code)
                                            <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                            </div>

                        </div>


                        <br>
                        <div class="border p-3">

                            <div class="row">
                                @foreach($langs as $index => $lang)
                                    <div class="form-group col-md-6">
                                        <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label> <!-- Translated Label -->
                                        <textarea class="form-control" name="meta_des[{{$lang->code}}]" >{{ old('meta_des.' . $lang->code) }}</textarea>
                                        @error('meta_des.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                        </div>




                        <br>
                        <div class="border p-3">

                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="image">{{ __('main.image') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="image" type="file" class="custom-file-input" id="image">
                                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translated Choose Image -->
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translated Upload -->
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <img id="avatar-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                                        </div>


                                        <div class="progress mt-2 d-none" id="upload-progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar">0%</div>
                                        </div>



                                        @error('image')
                                        <div class="text-danger">{{ $errors->first('image') }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="thumbinal">{{ __('main.thumbinal') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbinal" type="file" class="custom-file-input" id="thumbinal">
                                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label> <!-- Translated Choose Image -->
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ __('main.upload') }}</span> <!-- Translated Upload -->
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <img id="avatar-preview-thumbinal" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                                        </div>


                                        <div class="progress mt-2 d-none" id="upload-progress-thumbinal">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="upload-progress-bar-thumbinal">0%</div>
                                        </div>



                                        @error('thumbinal')
                                        <div class="text-danger">{{ $errors->first('thumbinal') }}</div>
                                        @enderror
                                    </div>




                                </div>

                        </div>



{{--                        <div class="form-group">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <label>{{ __('main.star') }}</label> <!-- Translated Label -->--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input name="start" type="checkbox" class="custom-control-input" id="customCheck2">--}}
{{--                                        <label class="custom-control-label" for="customCheck2"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @error('start')--}}
{{--                            <div class="text-danger">{{ $errors->first('start') }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}



                        <br>
                        <div class="border p-3">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.category') }}</label> <!-- Translated Label -->
                                    <select name="category_id" class="form-control">
                                        <option value="">{{ __('main.select_category') }}</option> <!-- Translated Option -->
                                        @forelse($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('category')
                                    <div class="text-danger">{{ $errors->first('category') }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.brand') }}</label>
                                    <select name="brand_id" class="form-control">
                                        <option value="">{{ __('main.select_brand') }}</option> <!-- Translated Option -->
                                        @forelse($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('brand')
                                    <div class="text-danger">{{ $errors->first('brand') }}</div>
                                    @enderror
                                </div>

                            </div>


                        </div>



                        <br>
                        <div class="border p-3">


                            <div class="form-group">
                                <label for="weight">{{ __('main.weight') }} (GRAM)</label>
                                <input type="number" name="weight" class="form-control" id="weight" placeholder="{{ __('main.enter_weight') }}" value="{{ old('weight') }}">
                                @error('weight')
                                <div class="text-danger">{{ $errors->first('weight') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="length">{{ __('main.dimenstion') }} (CM)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="number" name="length" class="form-control" id="length" placeholder="{{ __('main.enter_length') }}" value="{{ old('length') }}">
                                        @error('length')
                                        <div class="text-danger">{{ $errors->first('length') }}</div>
                                        @enderror

                                    </div>


                                    <div class="col-md-4">
                                        <input type="number" name="width" class="form-control" id="width" placeholder="{{ __('main.enter_width') }}" value="{{ old('width') }}">
                                        @error('width')
                                        <div class="text-danger">{{ $errors->first('width') }}</div>
                                        @enderror

                                    </div>



                                    <div class="col-md-4">
                                        <input type="number" name="height" class="form-control" id="height" placeholder="{{ __('main.enter_height') }}" value="{{ old('height') }}">
                                        @error('height')
                                        <div class="text-danger">{{ $errors->first('height') }}</div>
                                        @enderror

                                    </div>

                                </div>

                            </div>




                        </div>

                        <br>
                        <div class="border p-3">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="related_products">{{ __('main.related_products') }}</label>
                                    <select name="related_products[]" id="related-products" class="form-control select2" multiple="multiple">
                                        <option value="0">{{ __('main.select_related_products') }}</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ in_array($product->id, old('related_products', [])) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('related_products')
                                    <div class="text-danger">{{ $errors->first('related_products') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">{{ __('main.status') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('main.published') }}</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('main.pending') }}</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.submit') }}</button> <!-- Translated Button -->
                    </div>

                </form>
            </div>

        </div>
    </section>
@endsection


@section('scripts')

    <script>

        $(document).ready(function () {
            // Initialize Select2 for the related products
            $('#related-products').select2({
                placeholder: "{{ __('main.select_related_products') }}",  // Placeholder text for the select2 input
                allowClear: true
            });
        });



        document.getElementById("image").addEventListener("change", function (event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                // Preview Image
                const preview = document.getElementById("avatar-preview");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                // Simulated Progress
                const progressBar = document.getElementById("upload-progress-bar");
                const progressContainer = document.getElementById("upload-progress");
                progressContainer.classList.remove("d-none");

                let progress = 0;
                const interval = setInterval(() => {
                    if (progress >= 100) {
                        clearInterval(interval);
                    } else {
                        progress += 10;
                        progressBar.style.width = progress + "%";
                        progressBar.innerText = progress + "%";
                    }
                }, 100);
            }
        });


        document.getElementById("thumbinal").addEventListener("change", function (event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                // Preview Image
                const preview = document.getElementById("avatar-preview-thumbinal");
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");

                // Simulated Progress
                const progressBar = document.getElementById("upload-progress-bar-thumbinal");
                const progressContainer = document.getElementById("upload-progress-thumbinal");
                progressContainer.classList.remove("d-none");

                let progress = 0;
                const interval = setInterval(() => {
                    if (progress >= 100) {
                        clearInterval(interval);
                    } else {
                        progress += 10;
                        progressBar.style.width = progress + "%";
                        progressBar.innerText = progress + "%";
                    }
                }, 100);
            }
        });







    </script>
@endsection
