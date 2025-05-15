
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
            <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="background-color: #17a2b8;color:#FFF">
                {{ ( app()->getLocale() ) == 'en' ? 'English':'العربيه' }}
            </button>
            <ul class="dropdown-menu" style="left:30px !important">

                <li class="dropdown-item" {{ ( app()->getLocale() ) == 'en' ? 'selected':'' }}> <a href="{{ route('change_direction_data_entry' , ['lang'=>'en']) }}" >English</a></li>
                <li class="dropdown-item" {{ ( app()->getLocale() ) == 'ar' ? 'selected':'' }}><a href="{{ route('change_direction_data_entry' , ['lang'=>'ar']) }}" >العربيه</a></li>
            </ul>
        </div>



    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('data_entry.home.index')}}" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="data_entryLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Cairo Zoo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('dist/img/canGrowlogo.png')}}" class="img-circle elevation-2" alt="User Image" style="width: 35px;height: 35px">
            </div>
            <div class="info">
                <a href="#" class="d-block">CanGrow Dashboard</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">








            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-globe"></i>
                                    <p>
                                        {{ __('main.brands') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('data_entry.brands.index') }}" class="nav-link">
                                            <i class="fa fa-globe nav-icon"></i>
                                            <p>{{ __('main.brands') }}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('data_entry.brands.add') }}" class="nav-link">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>{{ __('main.add') }}</p>
                                        </a>
                                    </li>


                                </ul>
            </li>




            <li class="nav-item has-treeview">

                            <a href="#" class="nav-link">
                                <i class="fa fa-bars nav-icon"></i>
                                <p>
                                    {{ __('main.category') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('data_entry.category.index') }}" class="nav-link">
                                        <i class="fa fa-bars nav-icon"></i>
                                        <p>{{ __('main.category') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('data_entry.category.add') }}" class="nav-link">
                                        <i class="fa fa-plus nav-icon"></i>
                                        <p>{{ __('main.add') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



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
                                                    <a href="{{ route('data_entry.products.index') }}" class="nav-link">
                                                        <i class="fas fa-box nav-icon"></i>

                                                        <p>{{ __('main.products') }}</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('data_entry.products.add') }}" class="nav-link">
                                                        <i class="fa fa-plus nav-icon"></i>
                                                        <p>{{ __('main.add') }}</p>
                                                    </a>
                                                </li>


                                                <!-- <li class="nav-item">
                                                    <a href="{{ route('admin.featured.index') }}" class="nav-link">
                                                        <i class="fa fa-plus nav-icon"></i>
                                                        <p>{{ __('main.featured') }}</p>
                                                    </a>
                                                </li> -->


                                            </ul>
                                        </li>



                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="fa fa-newspaper nav-icon"></i>
                                                <p>
                                                    {{ __('main.cms') }}
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="{{ route('data_entry.cms.index') }}" class="nav-link">
                                                        <i class="fa fa-newspaper nav-icon"></i>
                                                        <p>{{ __('main.cms') }}</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('data_entry.cms.add') }}" class="nav-link">
                                                        <i class="fa fa-plus nav-icon"></i>
                                                        <p>{{ __('main.add') }}</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-image"></i>
                        <p>
                            {{ __('main.sliders') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('data_entry.sliders.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-image"></i>
                                <p>{{ __('main.sliders') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_entry.sliders.add') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>{{ __('main.add') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_entry.sliders.setting') }}" class="nav-link">
                                <i class="fa fa-cog nav-icon"></i>
                                <p>{{ __('main.setting') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-phone-volume"></i>
                        <p>
                            {{ __('main.contact_us') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('data_entry.contact.index') }}" class="nav-link">
                                <i class="fa fa-phone-volume"></i>
                                <p>{{ __('main.contact_us') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-address-card nav-icon"></i>
                        <p>
                            {{ __('main.about_us') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('data_entry.about.index') }}" class="nav-link">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>{{ __('main.about_us') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa fa-newspaper nav-icon"></i>
                        <p>
                            {{ __('main.mission_vission') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('data_entry.mission_vission.index') }}" class="nav-link">
                                <i class="fa fa-newspaper nav-icon"></i>
                                <p>{{ __('main.mission_vission') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>




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
                                <a href="{{ route('data_entry.auth.logout') }}" class="nav-link">
                                    <i class="fa fa-sign-out-alt nav-icon"></i>
                                    <p>{{ __('main.logout') }}</p>
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
