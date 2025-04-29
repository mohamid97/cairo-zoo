@extends('admin.layout.master')

@section('styles')
    <style>
        .pointer{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                @if($settings->finish != 1)
                    <p class="alert alert-danger" style="text-align: center"> من فضلك قم بتحديد لغات الموقع قبل ضبط الإعدادت في البدايه</p>

                @endif

                <div class="card-header">
                    <h3 class="card-title">Settings</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.settings.update') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">


                        @foreach($langs as $lang)
                        <div class="form-group">
                            <label for="working_hours">Working Hours ({{ $lang->name }}) </label>
                            <input type="text" name="working_hours[{{$lang->code}}]" class="form-control" id="working_hours" placeholder="" value=" {{isset($settings->translate($lang->code)->working_hours) ? $settings->translate($lang->code)->working_hours :''}} ">
                            @error('working_hours.' . $lang->code)
                            <div class="text-danger">{{ $errors->first('working_hours.' . $lang->code) }}</div>
                            @enderror
                        </div>
                       @endforeach




                            <div class="form-group">
                                <label for="logo">{{ __('main.logo') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="logo" type="file" class="custom-file-input" id="logo">
                                        <label class="custom-file-label" for="logo">{{ __('main.choose_logo') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('uploads/images/setting/' . $settings->logo) }}" width="150" height="150" alt="Logo Preview">

                                @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="favicon">{{ __('main.favicon') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="favicon" type="file" class="custom-file-input" id="favicon">
                                        <label class="custom-file-label" for="favicon">{{ __('main.choose_favicon') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('uploads/images/setting/' . $settings->favicon) }}" width="150" height="150" alt="Favicon Preview">

                                @error('favicon')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="home_breadcrumb_background">{{ __('main.home_breadcrumb_background') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="home_breadcrumb_background" type="file" class="custom-file-input" id="home_breadcrumb_background">
                                        <label class="custom-file-label" for="home_breadcrumb_background">{{ __('main.choose_background') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('uploads/images/setting/' . $settings->home_breadcrumb_background) }}" width="150" height="150" alt="Home Breadcrumb Background Preview">

                                @error('home_breadcrumb_background')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="about_breadcrumb_background">{{ __('main.about_breadcrumb_background') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="about_breadcrumb_background" type="file" class="custom-file-input" id="about_breadcrumb_background">
                                        <label class="custom-file-label" for="about_breadcrumb_background">{{ __('main.choose_background') }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('main.upload') }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('uploads/images/setting/' . $settings->about_breadcrumb_background) }}" width="150" height="150" alt="About Breadcrumb Background Preview">

                                @error('about_breadcrumb_background')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>







                        <div class="form-group">
                            <label for="contact_breadcrumb_background">Contact Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="contact_breadcrumb_background" type="file" class="custom-file-input" id="contact_breadcrumb_background">
                                    <label class="custom-file-label" for="contact_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->contact_breadcrumb_background)}}" width="150px" height="150px">

                            @error('contact_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('contact_breadcrumb_background') }}</div>
                            @enderror
                        </div>




                        <div class="form-group">
                            <label for="products_breadcrumb_background">Products Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="products_breadcrumb_background" type="file" class="custom-file-input" id="products_breadcrumb_background">
                                    <label class="custom-file-label" for="products_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->products_breadcrumb_background)}}" width="150px" height="150px">

                            @error('products_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('products_breadcrumb_background') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="categories_breadcrumb_background">Categories Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="categories_breadcrumb_background" type="file" class="custom-file-input" id="categories_breadcrumb_background">
                                    <label class="custom-file-label" for="categories_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->categories_breadcrumb_background)}}" width="150px" height="150px">

                            @error('categories_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('categories_breadcrumb_background') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="category_details_breadcrumb_background">Category Details Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="category_details_breadcrumb_background" type="file" class="custom-file-input" id="category_details_breadcrumb_background">
                                    <label class="custom-file-label" for="category_details_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->category_details_breadcrumb_background)}}" width="150px" height="150px">

                            @error('category_details_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('category_details_breadcrumb_background') }}</div>
                            @enderror
                        </div>




                        <div class="form-group">
                            <label for="services_breadcrumb_background">Services Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="services_breadcrumb_background" type="file" class="custom-file-input" id="services_breadcrumb_background">
                                    <label class="custom-file-label" for="services_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->services_breadcrumb_background)}}" width="150px" height="150px">

                            @error('services_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('services_breadcrumb_background') }}</div>
                            @enderror
                        </div>




                        <div class="form-group">
                            <label for="service_details_breadcrumb_background">Service Details Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="service_details_breadcrumb_background" type="file" class="custom-file-input" id="service_details_breadcrumb_background">
                                    <label class="custom-file-label" for="service_details_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->service_details_breadcrumb_background)}}" width="150px" height="150px">

                            @error('service_details_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('service_details_breadcrumb_background') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="our_work_breadcrumb_background">Prjects Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="our_work_breadcrumb_background" type="file" class="custom-file-input" id="our_work_breadcrumb_background">
                                    <label class="custom-file-label" for="our_work_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->our_work_breadcrumb_background)}}" width="150px" height="150px">

                            @error('our_work_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('our_work_breadcrumb_background') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="our_work_breadcrumb_background">Blog Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="blog_breadcrumb_background" type="file" class="custom-file-input" id="blog_breadcrumb_background">
                                    <label class="custom-file-label" for="blog_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->blog_breadcrumb_background)}}" width="150px" height="150px">

                            @error('blog_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('blog_breadcrumb_background') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="our_work_breadcrumb_background">Blog Details Breadcrumb Background</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="blog_details_breadcrumb_background" type="file" class="custom-file-input" id="blog_details_breadcrumb_background">
                                    <label class="custom-file-label" for="blog_details_breadcrumb_background">Choose Background</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/setting/'. $settings->blog_details_breadcrumb_background)}}" width="150px" height="150px">

                            @error('blog_details_breadcrumb_background')
                            <div class="text-danger">{{ $errors->first('blog_details_breadcrumb_background') }}</div>
                            @enderror
                        </div>












                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="website_name">Website Name ({{ $lang->name }}) </label>
                                <input type="text" name="website_name[{{$lang->code}}]" class="form-control" id="website_name" placeholder="Enter Website Name" value=" {{$settings->translate($langs[0]->code)->website_name}} ">
                                @error('website_name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('website_name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach




                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="website_des">Website Description ({{ $lang->name }}) </label>
                                <input type="text" name="website_des[{{$lang->code}}]" class="form-control" id="website_des" placeholder="Enter Website Description" value="{{$settings->translate($langs[0]->code)->website_des}}">
                                @error('website_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('website_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach




                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="pointer" onclick="toggleAllCheckboxes()">Check All</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkAll" onclick="toggleAllCheckboxes()">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <h3> Tabs </h3>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                   <lable  class="pointer" onclick="toggleCheckbox('customCheck1')">Show/Hide - Sliders</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->slider ?'checked':'')}} name="slider" type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1"></label>
                                    </div>
                                </div>
                            </div>
                            @error('slider')
                            <div class="text-danger">{{ $errors->first('slider') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck2')">Show/Hide - About Us</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->about_us ?'checked':'')}} name="about_us" type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2"></label>
                                    </div>
                                </div>
                            </div>
                            @error('about_us')
                            <div class="text-danger">{{ $errors->first('about_us') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck2')">Show/Hide - parteners</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->parteners ?'checked':'')}} name="parteners" type="checkbox" class="custom-control-input" id="customCheck2d">
                                        <label class="custom-control-label" for="customCheck2d"></label>
                                    </div>
                                </div>
                            </div>
                            @error('parteners')
                            <div class="text-danger">{{ $errors->first('parteners') }}</div>
                            @enderror
                        </div>





                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck002')">Show/Hide - Mission Vission</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->mission_vission ?'checked':'')}} name="mission_vission" type="checkbox" class="custom-control-input" id="customCheck002">
                                        <label class="custom-control-label" for="customCheck002"></label>
                                    </div>
                                </div>
                            </div>
                            @error('mission_vission')
                            <div class="text-danger">{{ $errors->first('mission_vission') }}</div>
                            @enderror
                        </div>





                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck__00')">Show/Hide -  Shimpment </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->shimpment ?'checked':'')}} name="shimpment" type="checkbox" class="custom-control-input" id="customCheck__00">
                                        <label class="custom-control-label" for="customCheck__00"></label>
                                    </div>
                                </div>
                            </div>
                            @error('shimpment')
                            <div class="text-danger">{{ $errors->first('shimpment') }}</div>
                            @enderror
                        </div>

                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('customCheck__brand')">Show/Hide -  Brand </lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->brand ?'checked':'')}} name="brand" type="checkbox" class="custom-control-input" id="customCheck__brand">
                                            <label class="custom-control-label" for="customCheck__brand"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('brand')
                                <div class="text-danger">{{ $errors->first('brand') }}</div>
                                @enderror
                            </div>



                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('customCheck__weight')">Show/Hide -  Weight </lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->weight ?'checked':'')}} name="weight" type="checkbox" class="custom-control-input" id="customCheck__weight">
                                            <label class="custom-control-label" for="customCheck__weight"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('weight')
                                <div class="text-danger">{{ $errors->first('weight') }}</div>
                                @enderror
                            </div>




                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('customCheck__event')">Show/Hide -  Events </lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->event ?'checked':'')}} name="event" type="checkbox" class="custom-control-input" id="customCheck__event">
                                            <label class="custom-control-label" for="customCheck__event"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('event')
                                <div class="text-danger">{{ $errors->first('event') }}</div>
                                @enderror
                            </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck00')">Show/Hide -  Messages </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->messages ?'checked':'')}} name="messages" type="checkbox" class="custom-control-input" id="customCheck00">
                                        <label class="custom-control-label" for="customCheck00"></label>
                                    </div>
                                </div>
                            </div>
                            @error('messages')
                            <div class="text-danger">{{ $errors->first('messages') }}</div>
                            @enderror
                        </div>







                            <!--- here -->

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('feedback5')">Show/Hide - Feedbacks </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->feedback ?'checked':'')}} name="feedback" type="checkbox" class="custom-control-input" id="feedback5">
                                        <label class="custom-control-label" for="feedback5"></label>
                                    </div>
                                </div>
                            </div>
                            @error('feedback')
                            <div class="text-danger">{{ $errors->first('feedback') }}</div>
                            @enderror
                        </div>




                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck010')">Show/Hide -  Payments </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->payments ?'checked':'')}} name="payments" type="checkbox" class="custom-control-input" id="customCheck010">
                                        <label class="custom-control-label" for="customCheck010"></label>
                                    </div>
                                </div>
                            </div>
                            @error('messages')
                            <div class="text-danger">{{ $errors->first('messages') }}</div>
                            @enderror
                        </div>







                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck3')">Show/Hide - Contact Us</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->contact_us ?'checked':'')}} name="contact_us" type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3"></label>
                                    </div>
                                </div>
                            </div>
                            @error('contact_us')
                            <div class="text-danger">{{ $errors->first('contact_us') }}</div>
                            @enderror
                        </div>




                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck4')">Show/Hide - Social Media</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->social_media ?'checked':'')}} name="social_media" type="checkbox" class="custom-control-input" id="customCheck4">
                                        <label class="custom-control-label" for="customCheck4"></label>
                                    </div>
                                </div>
                            </div>
                            @error('social_media')
                            <div class="text-danger">{{ $errors->first('social_media') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck5')">Show/Hide - Clients </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->clients ?'checked':'')}} name="clients" type="checkbox" class="custom-control-input" id="customCheck5">
                                        <label class="custom-control-label" for="customCheck5"></label>
                                    </div>
                                </div>
                            </div>
                            @error('clients')
                            <div class="text-danger">{{ $errors->first('clients') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck6')">Show/Hide - Our works</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->our_works ?'checked':'')}} name="our_works" type="checkbox" class="custom-control-input" id="customCheck6">
                                        <label class="custom-control-label" for="customCheck6"></label>
                                    </div>
                                </div>
                            </div>
                            @error('our_works')
                            <div class="text-danger">{{ $errors->first('our_works') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck7')">Show/Hide - Categories</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->categories ?'checked':'')}} name="categories" type="checkbox" class="custom-control-input" id="customCheck7">
                                        <label class="custom-control-label" for="customCheck7"></label>
                                    </div>
                                </div>
                            </div>
                            @error('categories')
                            <div class="text-danger">{{ $errors->first('categories') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck8')">Show/Hide - Products </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->products ?'checked':'')}} name="products" type="checkbox" class="custom-control-input" id="customCheck8">
                                        <label class="custom-control-label" for="customCheck8"></label>
                                    </div>
                                </div>
                            </div>
                            @error('products')
                            <div class="text-danger">{{ $errors->first('products') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('stock123')">Show/Hide - Stock</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->stock ?'checked':'')}} name="stock" type="checkbox" class="custom-control-input" id="stock123">
                                        <label class="custom-control-label" for="stock123"></label>
                                    </div>
                                </div>
                            </div>
                            @error('stock')
                            <div class="text-danger">{{ $errors->first('stock') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('card')">Show/Hide - Card</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->card ?'checked':'')}} name="card" type="checkbox" class="custom-control-input" id="card">
                                        <label class="custom-control-label" for="card"></label>
                                    </div>
                                </div>
                            </div>
                            @error('card')
                            <div class="text-danger">{{ $errors->first('card') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('orders')">Show/Hide - Orders</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->orders ?'checked':'')}} name="orders" type="checkbox" class="custom-control-input" id="orders">
                                        <label class="custom-control-label" for="orders"></label>
                                    </div>
                                </div>
                            </div>
                            @error('orders')
                            <div class="text-danger">{{ $errors->first('orders') }}</div>
                            @enderror
                        </div>




                       <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('tags')">Show/Hide - Tags</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->tags ?'checked':'')}} name="tags" type="checkbox" class="custom-control-input" id="tags">
                                            <label class="custom-control-label" for="tags"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('tags')
                                <div class="text-danger">{{ $errors->first('tags') }}</div>
                                @enderror
                            </div>





                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck9')">Show/Hide - Services</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->services ?'checked':'')}} name="services" type="checkbox" class="custom-control-input" id="customCheck9">
                                        <label class="custom-control-label" for="customCheck9"></label>
                                    </div>
                                </div>
                            </div>
                            @error('services')
                            <div class="text-danger">{{ $errors->first('services') }}</div>
                            @enderror
                        </div>




                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('discounts')">Show/Hide - Discounts</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->discounts ?'checked':'')}} name="discounts" type="checkbox" class="custom-control-input" id="discounts">
                                            <label class="custom-control-label" for="discounts"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('discounts')
                                <div class="text-danger">{{ $errors->first('discounts') }}</div>
                                @enderror
                            </div>



                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="coupons" onclick="toggleCheckbox('coupons')"> Show/Hide - Coupons </lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->coupons ?'checked':'')}} name="coupons" type="checkbox" class="custom-control-input" id="coupons">
                                            <label class="custom-control-label" for="coupons"></label>
                                        </div>
                                    </div>
                                </div>

                                @error('coupons')
                                <div class="text-danger">{{ $errors->first('coupons') }}</div>
                                @enderror


                            </div>






                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck10')">Show/Hide - Blog</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->cms ?'checked':'')}} name="cms" type="checkbox" class="custom-control-input" id="customCheck10">
                                        <label class="custom-control-label" for="customCheck10"></label>
                                    </div>
                                </div>
                            </div>
                            @error('cms')
                            <div class="text-danger">{{ $errors->first('cms') }}</div>
                            @enderror
                        </div>


                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('ourteam1')">Show/Hide - our team</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->ourteam ?'checked':'')}} name="ourteam" type="checkbox" class="custom-control-input" id="ourteam1">
                                            <label class="custom-control-label" for="ourteam1"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('ourteam')
                                <div class="text-danger">{{ $errors->first('ourteam') }}</div>
                                @enderror
                            </div>





                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck11')">Show/Hide - Media</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->media ?'checked':'')}} name="media" type="checkbox" class="custom-control-input" id="customCheck11">
                                        <label class="custom-control-label" for="customCheck11"></label>
                                    </div>
                                </div>
                            </div>
                            @error('media')
                            <div class="text-danger">{{ $errors->first('media') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck44')">Show/Hide - Description</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->des ?'checked':'')}} name="des" type="checkbox" class="custom-control-input" id="customCheck44">
                                        <label class="custom-control-label" for="customCheck44"></label>
                                    </div>
                                </div>
                            </div>
                            @error('des')
                            <div class="text-danger">{{ $errors->first('des') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('customCheck45')">Show/Hide - Achievement</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->achievement ?'checked':'')}} name="achievement" type="checkbox" class="custom-control-input" id="customCheck45">
                                        <label class="custom-control-label" for="customCheck45"></label>
                                    </div>
                                </div>
                            </div>
                            @error('achievement')
                            <div class="text-danger">{{ $errors->first('achievement') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable class="pointer" onclick="toggleCheckbox('offers')">Show/Hide - Offers</lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($settings->offers ?'checked':'')}} name="offers" type="checkbox" class="custom-control-input" id="offers">
                                        <label class="custom-control-label" for="offers"></label>
                                    </div>
                                </div>
                            </div>
                            @error('offers')
                            <div class="text-danger">{{ $errors->first('offers') }}</div>
                            @enderror
                        </div>





                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('customCheck0021points')">Show/Hide - Points</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->points ?'checked':'')}} name="points" type="checkbox" class="custom-control-input" id="customCheck0021points">
                                            <label class="custom-control-label" for="customCheck0021points"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('points')
                                <div class="text-danger">{{ $errors->first('points') }}</div>
                                @enderror
                            </div>





                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('customCheck002pages')">Show/Hide - Pages</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->pages ?'checked':'')}} name="pages" type="checkbox" class="custom-control-input" id="customCheck002pages">
                                            <label class="custom-control-label" for="customCheck002pages"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('pages')
                                <div class="text-danger">{{ $errors->first('pages') }}</div>
                                @enderror
                            </div>




                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-8">
                                        <lable class="pointer" onclick="toggleCheckbox('sales_tool')">Show/Hide - Sales Tool</lable>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input {{($settings->sales_tool ?'checked':'')}} name="sales_tool" type="checkbox" class="custom-control-input" id="sales_tool">
                                            <label class="custom-control-label" for="sales_tool"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('sales_tool')
                                <div class="text-danger">{{ $errors->first('sales_tool') }}</div>
                                @enderror
                            </div>


                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> Update</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection


@section('scripts')
    <script>
        function toggleCheckbox(id) {
            const checkbox = document.getElementById(id);
            checkbox.checked = !checkbox.checked;
        }

        function toggleAllCheckboxes() {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.custom-control-input');

            // Loop through all checkboxes and set their checked state to match "Check All"
            checkboxes.forEach(function(checkbox) {
                if (checkbox !== checkAll) {
                    checkbox.checked = checkAll.checked;
                }
            });
        }
    </script>
@endsection



