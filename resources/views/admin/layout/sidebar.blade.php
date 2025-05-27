<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

    </ul>



    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">

        <div class="input-group-prepend">
            <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-expanded="false"
                style="background-color: #17a2b8;color:#FFF">
                {{ ( app()->getLocale() ) == 'en' ? 'English':'العربيه' }}
            </button>
            <ul class="dropdown-menu" style="left:30px !important">

                <li class="dropdown-item" {{ ( app()->getLocale() ) == 'en' ? 'selected':'' }}> <a
                        href="{{ route('change_direction' , ['lang'=>'en']) }}">English</a></li>
                <li class="dropdown-item" {{ ( app()->getLocale() ) == 'ar' ? 'selected':'' }}><a
                        href="{{ route('change_direction' , ['lang'=>'ar']) }}">العربيه</a></li>
            </ul>
        </div>



    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.index')}}" class="brand-link">
        <img src="{{asset('dist/img/CZ-LOGO-2021.webp')}}" alt="AdminLTE Logo" class="brand-image img-circle "
            style="opacity: 1">
        <span class="brand-text font-weight-light">Cairo Zoo</span>
    </a>






    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('dist/img/canGrowlogo.png')}}" class="img-circle " alt="User Image" style="    height: 45px;
    width: 45px;">
            </div>
            <div class="info">
                <a href="#" class="d-block">CanGrow Dashboard</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @if($settings->finish )


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-bar"></i>

                        <p>
                            {{ __('main.statistics') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.statistics.diff') }}" class="nav-link">--}}
{{--                                <i class="fas fa-balance-scale"></i>--}}
{{--                                <p>{{ __('main.difference') }}</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}


                        <li class="nav-item">
                            <a href="{{ route('admin.statistics.store') }}" class="nav-link">
                                <i class="fas fa-receipt"></i>

                                <p>{{ __('main.store_data') }}</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.statistics.orders') }}" class="nav-link">
                                <i class="fas fa-receipt"></i>

                                <p>{{ __('main.orders') }}</p>
                            </a>
                        </li>




                        <li class="nav-item">
                            <a href="{{ route('admin.statistics.monthly_report') }}" class="nav-link">
                                <i class="fas fa-receipt"></i>

                                <p>{{ __('main.monthly_report') }}</p>
                            </a>
                        </li>








                    </ul>
                </li>




                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>

                        <p>
                            {{ __('main.ecommerce') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.cahier_orders.index') }}" class="nav-link">
                                <i class="fas fa-receipt nav-icon"></i>

                                <p>{{ __('main.cashier_orders') }}</p>
                            </a>
                        </li>

                        @if($settings->orders)
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                                    <i class="fa fa-receipt nav-icon"></i>
                                    <p>{{ __('main.orders') }}</p>
                                </a>
                            </li>
                        @endif
                        @if($settings->card)
                            <li class="nav-item">
                                <a href="{{ route('admin.cards.index') }}" class="nav-link">
                                    <i class="fa fa-cart-plus nav-icon"></i>
                                    <p>{{ __('main.carts') }}</p>
                                </a>
                            </li>
                         @endif

                        @if($settings->discounts)
                            <li class="nav-item">
                                <a href="{{ route('admin.discounts.index') }}" class="nav-link">
                                    <i class="fas fa-money-bill-wave nav-icon"></i>

                                    <p>{{ __('main.discounts') }}</p>
                                </a>
                            </li>
                        @endif

                        @if($settings->coupons)
                            <li class="nav-item">
                                <a href="{{ route('admin.coupons.index') }}" class="nav-link">
                                    <i class="fas fa-money-bill-wave nav-icon"></i>

                                    <p>{{ __('main.coupons') }}</p>
                                </a>
                            </li>
                         @endif

                        @if($settings->points)
                            <li class="nav-item">
                                <a href="{{route('admin.points.index')}}"
                                   class="nav-link">
                                    <i class="fas fa-coins"></i>
                                    <p> @lang('main.points')  </p>
                                </a>
                            </li>
                        @endif

                        @if($settings->shimpment)
                            <li class="nav-item">
                                <a href="{{ route('admin.shimpments.index') }}" class="nav-link">
                                    <i class="fas fa-car nav-icon"></i>
                                    <p>{{ __('main.shipments') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.shimpments.Show_zone') }}" class="nav-link">
                                    <i class="fas fa-eye nav-icon"></i>
                                    <p>{{ __('main.show_zone') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.shimpments.show_city') }}" class="nav-link">
                                    <i class="fas fa-eye nav-icon"></i>
                                    <p>{{ __('main.show_city') }}</p>
                                </a>
                            </li>

                         @endif
                    </ul>
                </li>



                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user"></i>

                            <p>
                                {{ __('main.profile') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>


                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>{{ __('main.my_users') }}</p>
                                </a>
                            </li>
                            @if($settings->slider)
                                <li class="nav-item">
                                    <a href="{{ route('admin.sliders.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-image"></i>
                                        <p>{{ __('main.sliders') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.sliders.setting') }}" class="nav-link">
                                        <i class="fa fa-cog nav-icon"></i>
                                        <p>{{ __('main.slider_setting') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if($settings->about_us)
                                <li class="nav-item">
                                    <a href="{{ route('admin.about.index') }}" class="nav-link">
                                        <i class="far fa-address-card nav-icon"></i>
                                        <p>{{ __('main.about_us') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if($settings->contact_us)
                                <li class="nav-item">
                                    <a href="{{ route('admin.contact.index') }}" class="nav-link">
                                        <i class="fa fa-phone-volume"></i>
                                        <p>{{ __('main.contact_us') }}</p>
                                    </a>
                                </li>

                            @endif

                            @if($settings->social_media)
                                <li class="nav-item">
                                    <a href="{{ route('admin.social_media.index') }}"
                                       class="nav-link">
                                        <i class="fa fa-hashtag nav-icon"></i>
                                        <p>{{ __('main.social_media') }}</p>
                                    </a>
                                </li>

                             @endif

                            @if($settings->cms)
                                <li class="nav-item">
                                    <a href="{{ route('admin.cms.index') }}" class="nav-link">
                                        <i class="fa fa-newspaper nav-icon"></i>
                                        <p>{{ __('main.cms') }}</p>
                                    </a>
                                </li>
                             @endif

                            @if($settings->messages)
                                <li class="nav-item">
                                    <a href="{{ route('admin.messages.index') }}" class="nav-link">
                                        <i class="fa fa-comments nav-icon"></i>
                                        <p>{{ __('main.messages') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if($settings->mission_vission)
                                <li class="nav-item">
                                    <a href="{{ route('admin.mission_vission.index') }}" class="nav-link">
                                        <i class="fa fa-newspaper nav-icon"></i>
                                        <p>{{ __('main.mission_vission') }}</p>
                                    </a>
                                </li>

                             @endif




                        </ul>
                    </li>



                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-industry"></i>


                            <p>
                                {{ __('main.brands_categories') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>


                        <ul class="nav nav-treeview">
                            @if($settings->brand)
                                <li class="nav-item">
                                    <a href="{{ route('admin.brands.index') }}" class="nav-link">
                                        <i class="fa fa-globe nav-icon"></i>
                                        <p>{{ __('main.brands') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if($settings->categories)
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index') }}" class="nav-link">
                                        <i class="fa fa-bars nav-icon"></i>
                                        <p>{{ __('main.category') }}</p>
                                    </a>
                                </li>

                             @endif



                        </ul>
                    </li>












                @if($settings->products)
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box nav-icon"></i>
                        <p>
                            {{ __('main.products') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link">
                                <i class="fas fa-box nav-icon"></i>

                                <p>{{ __('main.products') }}</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.tastes.index') }}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>{{ __('main.tastes') }}</p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ route('admin.products.add') }}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>{{ __('main.add') }}</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.products.add_stock') }}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>{{ __('main.stock') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.featured.index') }}" class="nav-link">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>{{ __('main.featured') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif



                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            <p>
                                {{ __('main.expense') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.expense.index') }}" class="nav-link">
                                    <i class="fas fa-calculator mr-2"></i>

                                    <p>{{ __('main.expense') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.expense.add') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>{{ __('main.add') }}</p>
                                </a>
                            </li>

                        </ul>
                    </li>











































                {{--                        @if($settings->weight)--}}
                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-weight-hanging"></i>--}}
                {{--                                    <p>--}}
                {{--                                        {{ __('main.weights') }}--}}
                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.weights.index') }}"
                class="nav-link">--}}
                {{--                                            <i class="far fa-volume-control-phone nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.weights') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}

                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.weights.add') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.add') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}


                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}


                {{--                        @if($settings->event)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-calendar nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.events') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.events.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-calendar nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.events') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}

                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.events.add') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}


                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}














                {{--                    @if($settings->clients)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-users nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.clients') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.our_clients.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-users nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.clients') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.our_clients.add') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}













                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-history nav-icon"></i>
                        <p>
                            {{ __('main.logs') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.logs.index') }}" class="nav-link">
                                <i class="fa fa-newspaper nav-icon"></i>
                                <p>{{ __('main.logs') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>










                {{--                    @if($settings->our_works)--}}
                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                    <p>--}}
                {{--                                        {{ __('main.our_works') }}--}}
                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.our_works.index') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.our_works') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}



                {{--                        @if($settings->ourteam )--}}
                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                    <p>--}}

                {{--                                        {{ __('main.our_team') }}--}}

                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}

                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{route('admin.ourteam.index')}}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                            <p>  {{ __('main.our_team') }} </p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}


                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{route('admin.ourteam.add')}}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-plus  nav-icon"></i>--}}
                {{--                                            <p>  {{ __('main.add') }} </p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}



                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}





                {{--                        @if($settings->pages)--}}
                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                    <p>--}}
                {{--                                        {{ __('main.pages') }}--}}
                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.pages.index') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-briefcase nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.pages') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}






                {{--                    <li class="nav-item has-treeview">--}}
                {{--                        <a href="#" class="nav-link">--}}
                {{--                            <i class="fa fa-search nav-icon"></i>--}}
                {{--                            <p>--}}
                {{--                                {{ __('main.website_meta') }}--}}
                {{--                                <i class="right fas fa-angle-left"></i>--}}
                {{--                            </p>--}}
                {{--                        </a>--}}
                {{--                        <ul class="nav nav-treeview">--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.index') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.meta') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.services') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.services') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.categories') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.categories') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.blogs') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.blogs') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.products') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.products') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a href="{{ route('admin.meta.projects') }}" class="nav-link">--}}
                {{--                                    <i class="fa fa-language nav-icon"></i>--}}
                {{--                                    <p>{{ __('main.projects') }}</p>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}






















                {{--                    @if($settings->tags)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-bars nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.tags') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.tags.index') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-bars nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.tags') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.tags.create') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}







                {{--                    @if($settings->feedback)--}}

                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-comments nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.feedbacks') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}

                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{route('admin.feedback.index')}}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-language nav-icon"></i>--}}
                {{--                                        <p>  {{ __('main.all') }} </p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}



                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{route('admin.feedback.index')}}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>  {{ __('main.add') }} </p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}


                {{--                            </ul>--}}
                {{--                        </li>--}}

                {{--                   @endif--}}






                {{--                    @if($settings->offers)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-tags nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.offers') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.offers.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-tags nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.offers') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.offers.add') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}










                {{--                        @if($settings->sales_tool)--}}
                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-wrench nav-icon"></i>--}}
                {{--                                    <p>--}}
                {{--                                        {{ __('main.sales_tool') }}--}}
                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.sales_tool.index') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-wrench nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.sales_tool') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}

                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.sales_tool.points') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-language nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.points') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}

                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}

                {{--                    @if($settings->services)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-building nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.services') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.services.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-building nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.services') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.services.add') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}



                {{--                    @if($settings->payments)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fas fa-dollar-sign nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.payments') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.payments.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fas fa-dollar-sign nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.payments') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.payments.status') }}"
                class="nav-link">--}}
                {{--                                        <i class="fas fa-dollar-sign nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.status') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}




                {{--                    @if($settings->parteners)--}}

                {{--                            <li class="nav-item has-treeview">--}}
                {{--                                <a href="#" class="nav-link">--}}
                {{--                                    <i class="fa fa-users nav-icon"></i>--}}
                {{--                                    <p>--}}
                {{--                                        {{ __('main.parteners') }}--}}
                {{--                                        <i class="right fas fa-angle-left"></i>--}}
                {{--                                    </p>--}}
                {{--                                </a>--}}
                {{--                                <ul class="nav nav-treeview">--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.parteners.index') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-users nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.parteners') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                    <li class="nav-item">--}}
                {{--                                        <a href="{{ route('admin.parteners.add') }}"
                class="nav-link">--}}
                {{--                                            <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                            <p>{{ __('main.add') }}</p>--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}


                {{--                     @endif--}}

                {{--                --}}




                {{--                    @if($settings->media)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-microphone nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.media') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.group_media.index') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-images nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.media_group') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.media.gallery') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-images nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.gallery') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.media.videos') }}"
                class="nav-link">--}}
                {{--                                        <i class="fa fa-video nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.video') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.media.files') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-file nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.files') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}

                {{--                    @if($settings->des)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-comment nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.des') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.des.index') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-comment nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.des') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.des.add') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-plus nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.add') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}

                {{--                    @if($settings->achievement)--}}
                {{--                        <li class="nav-item has-treeview">--}}
                {{--                            <a href="#" class="nav-link">--}}
                {{--                                <i class="fa fa-trophy nav-icon"></i>--}}
                {{--                                <p>--}}
                {{--                                    {{ __('main.ach') }}--}}
                {{--                                    <i class="right fas fa-angle-left"></i>--}}
                {{--                                </p>--}}
                {{--                            </a>--}}
                {{--                            <ul class="nav nav-treeview">--}}
                {{--                                <li class="nav-item">--}}
                {{--                                    <a href="{{ route('admin.ach.index') }}" class="nav-link">--}}
                {{--                                        <i class="fa fa-trophy nav-icon"></i>--}}
                {{--                                        <p>{{ __('main.ach') }}</p>--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                @endif--}}







                @endif


                <!-- start language and setting -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-cog nav-icon"></i>
                        <p>
                            {{ __('main.settings') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                                <i class="fa fa-cog nav-icon"></i>
                                <p>{{ __('main.settings') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.auth.showUpdate') }}" class="nav-link">
                                <i class="fa fa-info nav-icon"></i>
                                <p>{{ __('main.info') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.auth.logout') }}" class="nav-link">
                                <i class="fa fa-sign-out-alt nav-icon"></i>
                                <p>{{ __('main.logout') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-solid fa-cloud-download-alt nav-icon"></i>
                        <p>
                            {{ __('main.backup') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.backup.index') }}" class="nav-link">
                                <i class="fa fa-solid fa-cloud-download-alt nav-icon"></i>
                                <p>{{ __('main.backup') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>




                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-language nav-icon"></i>
                        <p>
                            {{ __('main.languages') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.lang.index') }}" class="nav-link">
                                <i class="fa fa-language nav-icon"></i>
                                <p>{{ __('main.languages') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>





            </ul>



        </nav>
        <!-- /.sidebar-menu -->
    </div>



    <!-- /.sidebar -->
</aside>
