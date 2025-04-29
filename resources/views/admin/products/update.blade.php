@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.update_product') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.update_product') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.product') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="name">{{ __('main.name') }} ({{ $lang->name }}) </label>
                                        <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name"
                                               placeholder="{{ __('main.enter_name') }}"
                                               value="{{ $product->translate($lang->code)->name ?? old('name.' . $lang->code) }}">
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
                                        <label for="slug">{{ __('main.slug') }} ({{ $lang->name }}) </label>
                                        <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug"
                                               placeholder="{{ __('main.enter_slug') }}"
                                               value="{{ $product->translate($lang->code)->slug ?? old('slug.' . $lang->code) }}">
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
                                    <input type="number" name="sales_price" class="form-control" id="price"
                                           placeholder="{{ __('main.enter_sales_price') }}"
                                           value="{{ $product->sales_price ?? old('sales_price') }}">
                                    @error('sales_price')
                                    <div class="text-danger">{{ $errors->first('sales_price') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="sku">{{ __('main.sku') }}</label>
                                    <input type="text" name="sku" class="form-control" id="sku"
                                           placeholder="{{ __('main.enter_sku') }}"
                                           value="{{ $product->sku ?? old('sku') }}">
                                    @error('sku')
                                    <div class="text-danger">{{ $errors->first('sku') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="video">{{ __('main.video') }}</label>
                                    <input type="url" name="video" class="form-control" id="video"
                                           placeholder="{{ __('main.enter_video') }}"
                                           value="{{ $product->video ?? old('video') }}">
                                    @error('video')
                                    <div class="text-danger">{{ $errors->first('video') }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="barcode">{{ __('main.barcode') }}</label>
                                    <input type="text" name="barcode" class="form-control" id="barcode"
                                           placeholder="{{ __('main.enter_barcode') }}"
                                    value="{{ $product->barcode }}" />
                                    @error('barcode')
                                    <div class="text-danger">{{ $errors->first('barcode') }}</div>
                                    @enderror
                                </div>





                            </div>
                        </div>

                        <br>
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $index => $lang)
                                    <div class="form-group col-md-6">
                                        <label for="small_des">{{ __('main.small_des') }} ({{$lang->name}})</label>
                                        <textarea class="form-control" name="small_des[{{$lang->code}}]">{{ $product->translate($lang->code)->small_des ?? old('small_des.' . $lang->code) }}</textarea>
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
                                    <label for="description">{{ __('main.des') }} ({{$lang->name}})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">
                                        {{ $product->translate($lang->code)->des ?? old('des.' . $lang->code) }}
                                    </textarea>
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
                                        <textarea class="form-control" name="meta_title[{{$lang->code}}]">{{ $product->translate($lang->code)->meta_title ?? old('meta_title.' . $lang->code) }}</textarea>
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
                                        <label for="meta_des">{{ __('main.meta_des') }} ({{$lang->name}})</label>
                                        <textarea class="form-control" name="meta_des[{{$lang->code}}]">{{ $product->translate($lang->code)->meta_des ?? old('meta_des.' . $lang->code) }}</textarea>
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
                                            <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ __('main.upload') }}</span>
                                        </div>
                                    </div>

                                    @if($product->image)
                                        <div class="mt-3">
                                            <img src="{{ asset('uploads/images/products/' . $product->image) }}" alt="Image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif

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
                                            <label class="custom-file-label" for="thumbinal">{{ __('main.choose_image') }}</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ __('main.upload') }}</span>
                                        </div>
                                    </div>

                                    @if($product->thumbinal)
                                        <div class="mt-3">
                                            <img src="{{ asset('uploads/images/products/' . $product->thumbinal) }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif

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

                        <br>
                        <div class="border p-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.category') }}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">{{ __('main.select_category') }}</option>
                                        @forelse($categories as $category)
                                            <option value="{{$category->id}}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('category_id')
                                    <div class="text-danger">{{ $errors->first('category_id') }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('main.brand') }}</label>
                                    <select name="brand_id" class="form-control">
                                        <option value="">{{ __('main.select_brand') }}</option>
                                        @forelse($brands as $brand)
                                            <option value="{{$brand->id}}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{$brand->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('brand_id')
                                    <div class="text-danger">{{ $errors->first('brand_id') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="border p-3">
                            <div class="form-group">
                                <label for="weight">{{ __('main.weight') }} (GRAM)</label>
                                <input type="number" name="weight" class="form-control" id="weight"
                                       placeholder="{{ __('main.enter_weight') }}"
                                       value="{{ $product->weight ?? old('weight') }}">
                                @error('weight')
                                <div class="text-danger">{{ $errors->first('weight') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="length">{{ __('main.dimenstion') }} (CM)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="number" name="length" class="form-control" id="length"
                                               placeholder="{{ __('main.enter_length') }}"
                                               value="{{ $product->length ?? old('length') }}">
                                        @error('length')
                                        <div class="text-danger">{{ $errors->first('length') }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <input type="number" name="width" class="form-control" id="width"
                                               placeholder="{{ __('main.enter_width') }}"
                                               value="{{ $product->width ?? old('width') }}">
                                        @error('width')
                                        <div class="text-danger">{{ $errors->first('width') }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <input type="number" name="height" class="form-control" id="height"
                                               placeholder="{{ __('main.enter_height') }}"
                                               value="{{ $product->height ?? old('height') }}">
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
                                        @foreach($products as $productItem)
                                            <option value="{{ $productItem->id }}"
                                                {{ in_array($productItem->id, $product->related_products ?? []) ? 'selected' : '' }}>
                                                {{ $productItem->name }}
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
                                        <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>{{ __('main.published') }}</option>
                                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>{{ __('main.pending') }}</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                placeholder: "{{ __('main.select_related_products') }}",
                allowClear: true
            });

            // Image preview for main image
            document.getElementById("image").addEventListener("change", function (event) {
                const input = event.target;
                const file = input.files[0];

                if (file) {
                    const preview = document.getElementById("avatar-preview");
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove("d-none");

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

            // Image preview for thumbnail
            document.getElementById("thumbinal").addEventListener("change", function (event) {
                const input = event.target;
                const file = input.files[0];

                if (file) {
                    const preview = document.getElementById("avatar-preview-thumbinal");
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove("d-none");

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
        });
    </script>
@endsection
