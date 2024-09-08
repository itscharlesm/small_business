<aside class="main-sidebar sidebar-dark-orange elevation-4">
    {{-- Brand Logo --}}
    <a href="" class="brand-link">
        <img src="{{ asset('images/sms-logo2.png') }}" alt="Infinit logo" class="brand-image text-center"
            style="width:100px;height:100px;">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Sidebar user panel --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(getAvatar(session('usr_id'))) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascipt:void(0)" data-toggle="modal" data-target="#userInfoModal"
                    class="d-block">{{ session('usr_first_name') }}</a>
                <span class="brand-text font-weight-light"
                    style="color:gray;"><small>{{ session('acc_name') }}</small></span>
            </div>
        </div>

        {{-- * Sidebar Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- ? Home --}}
                <li class="nav-item">
                    <a href="{{ action('App\Http\Controllers\AdminController@home') }}"
                        class="nav-link {{ request()->is('admin/home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                {{-- @ POS --}}
                <li class="nav-item {{ request()->is('pos/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('pos/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Point of Sale
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\POSController@pos_receive_main') }}"
                                class="nav-link {{ request()->is('pos/receive/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delivery Receive</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\POSController@pos_purchase_main') }}"
                                class="nav-link {{ request()->is('pos/purchase/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\POSController@pos_damages_main') }}"
                                class="nav-link {{ request()->is('pos/damages/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Record Damages</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ? Management --}}
                <li class="nav-header">Management</li>

                <li class="nav-item {{ request()->is('admin/utility*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/utility*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Utility
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@product_details') }}"
                                class="nav-link {{ request()->is('admin/utility/products') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Product Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@product_categories') }}"
                                class="nav-link {{ request()->is('admin/utility/categories') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@clients_manage') }}"
                                class="nav-link {{ request()->is('admin/utility/clients') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Clients</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@suppliers_manage') }}"
                                class="nav-link {{ request()->is('admin/utility/suppliers') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->is('admin/setup*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/setup*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Account
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\AdminController@setup') }}"
                                class="nav-link {{ request()->is('admin/setup') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setup Account</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('management/inactive/project') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Status</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ! Signout --}}
                <li class="nav-item">
                    <a href="{{ action('App\Http\Controllers\LoginController@logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out"></i>
                        <p>
                            Sign out
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>