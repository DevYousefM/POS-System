<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <div class="image">
                <img src="{{ asset("uploads/".auth()->user()->image) }}" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="{{route("dash.index")}}"
                   class="d-block">{{auth()->user()->first_name . " " . auth()->user()->last_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dash.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            @lang('site.home')
                        </p>
                    </a>
                </li>

                @if(auth()->user()->hasPermission("users_read"))
                    <li class="nav-item">
                        <a href="{{ route('dash.users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                @lang('site.users')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission("categories_read"))
                    <li class="nav-item">
                        <a href="{{ route('dash.categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                @lang('site.categories')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission("products_read"))
                    <li class="nav-item">
                        <a href="{{ route('dash.products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                @lang('site.products')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission("clients_read"))
                    <li class="nav-item">
                        <a href="{{ route('dash.clients.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                @lang('site.clients')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission("orders_read"))
                    <li class="nav-item">
                        <a href="{{ route('dash.orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                @lang('site.orders')
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('dash.expenses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            @lang('site.expenses')
                        </p>
                    </a>
                </li>
                <li class="nav-header" style="padding-top: 0.5rem;"></li>
                <li class="nav-item">
                    <a href="{{route("dash.dailyInvoice")}}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            @lang("site.dailyInvoice")
                        </p>
                    </a>
                </li>
                @if(auth()->user()->hasPermission("orders_read"))
                    <li class="nav-item">
                        <a href="{{route("dash.yearlyInvoice")}}" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                @lang("site.yearlyOrders")
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{route("dash.dailyExpenses")}}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            @lang("site.dailyExpenses")
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("dash.monthlyExpenses")}}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            @lang("site.monthlyExpenses")
                        </p>
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a href="{{ route('dash.trash.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-trash-alt"></i>
                        <p>
                            @lang('site.trash')
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
