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
                <a href="javascipt:void(0)" class="d-block">{{ session('usr_first_name') }}</a>
                <span class="brand-text font-weight-light"
                    style="color:gray;"><small>{{ session('acc_name') }}</small></span>
            </div>
        </div>

        {{-- * Sidebar Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Home --}}
                <li class="nav-item">
                    <a href="{{ action('App\Http\Controllers\AdminController@home') }}"
                        class="nav-link {{ request()->is('admin/home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                {{-- Point of Sale --}}
                <li class="nav-item {{ request()->is('pos/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('pos/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Transactions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\POSController@pos_receive_main') }}"
                                class="nav-link {{ request()->is('pos/receive/new-transaction') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Point of Sale</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\POSController@transaction_history') }}"
                                class="nav-link {{ request()->is('pos/receive/transactions') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaction History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Management --}}
                <li class="nav-header">Management</li>

                <li class="nav-item {{ request()->is('admin/utility*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/utility*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
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
                                <p>Manage Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@product_categories') }}"
                                class="nav-link {{ request()->is('admin/utility/categories') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\UtilityController@clients_manage') }}"
                                class="nav-link {{ request()->is('admin/utility/clients') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Inventory</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->is('admin/setup*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/setup*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Employee
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\AdminController@setup') }}"
                                class="nav-link {{ request()->is('admin/setup') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\AdminController@setup') }}"
                                class="nav-link {{ request()->is('admin/setup') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\AdminController@setup') }}"
                                class="nav-link {{ request()->is('admin/setup') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payroll</p>
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
                                <p>Account Information</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('App\Http\Controllers\AdminController@setup') }}"
                                class="nav-link {{ request()->is('admin/setup') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Settings</p>
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