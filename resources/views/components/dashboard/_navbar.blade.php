<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dash.index') }}" class="nav-link">@lang('site.home')</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dash.reset.db') }}" class="nav-link">@lang('site.reset.db')</a>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-language"></i>
            </a>
            <div class="dropdown-menu lang dropdown-menu-lg dropdown-menu-right">
                <?php $devider = 1; ?>
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                    @if ($devider % 2)
                        <div class="dropdown-divider"></div>
                    @endif
                    <?php $devider++; ?>
                @endforeach
            </div>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ route('logout') }}"
                    onclick="event.preventDefault();this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </form>
        </li>

    </ul>
</nav>

<!-- /.navbar -->
