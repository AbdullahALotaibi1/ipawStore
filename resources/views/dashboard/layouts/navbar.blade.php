<!-- NAVIGATION
    ================================================== -->

<nav class="navbar navbar-vertical fixed-right navbar-expand-md navbar-dark" id="sidebar">

    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="header-navbar-i d-none d-md-flex">
            <div class="logo-header">
                <img src="{{ asset('storage/images/logo/'. \App\Setting::all()->first()->logo_store.'') }}" class="navbar-brand-img
       mx-auto">
            </div>
            <div class="title-header">{{ \App\Setting::all()->first()->title }}</div>
        </div>

        <!-- User (xs) -->
        <div class="navbar-user d-md-none">

            <!-- Dropdown -->
            <div class="dropdown">

                <!-- Toggle -->
                <a >
                    <div class="avatar avatar-sm avatar-online">
                        <img src="{{ asset('storage/images/logo/'. \App\Setting::all()->first()->logo_store.'') }}"  class="avatar-img rounded-circle" alt="...">
                    </div>
                </a>



            </div>

        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">

            <!-- Home -->
            <ul class="navbar-nav" >
                <li class="nav-item" style="margin-top: 20px">
                    <a class="nav-link" href="{{ config('app.url') }}">
                        <i class="fas fa-reply-all"></i> <span class="title-link"> عرض المتجر </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.home') ? 'active' : '' }}" href="{{ route('dashboard.home') }}">
                        <i class="fas fa-home-lg-alt"></i> <span class="title-link"> الرئيسية </span>
                    </a>
                </li>
            </ul>

            <!-- Heading -->
                <h6 class="navbar-heading text-right">
                    الشهادات
                </h6>

            <!-- Certification -->
            <ul class="navbar-nav mb-md-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.groups.*') ? 'active' : '' }}" href="{{ route('dashboard.groups.index') }}">
                        <i class="fas fa-window-restore"></i> <span class="title-link"> المجموعات </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.customers.*') ? 'active' : '' }}" href="{{ route('dashboard.customers.index') }}">
                        <i class="fas fa-user-friends"></i> <span class="title-link"> المشتركين </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.applications.*') ? 'active' : '' }}" href="{{ route('dashboard.applications.index') }}">
                        <i class="fas fa-arrow-alt-square-up"></i> <span class="title-link"> الصندوق الذكي </span>
                    </a>
                </li>
            </ul>


            <!-- Heading -->
            <h6 class="navbar-heading text-right" style="margin-top: -15px;">
                الاشتراكات
            </h6>

            <!-- Certification -->
            <ul class="navbar-nav mb-md-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
                        <i class="fas fa-user-plus"></i> <span class="title-link"> الطلبات </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.active.code.index') ? 'active' : '' }}" href="{{ route('dashboard.active.code.index') }}">
                        <i class="fas fa-hashtag"></i> <span class="title-link"> اكواد التفعيل </span>
                    </a>
                </li>
            </ul>


            <!-- Heading -->
            <h6 class="navbar-heading text-right" style="margin-top: -15px;">
                اعدادات المتجر
            </h6>

            <!-- Certification -->
            <ul class="navbar-nav mb-md-4">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.accounts.*') ? 'active' : '' }}" href="{{ route('dashboard.accounts.index') }}">
                        <i class="fas fa-credit-card"></i> <span class="title-link"> طرق الدفع </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.settings.index') ? 'active' : '' }}" href="{{ route('dashboard.settings.index') }}">
                        <i class="fas fa-cogs"></i> <span class="title-link"> الاعدادات العامة </span>
                    </a>
                </li>

            </ul>

            <!-- Push content down -->
            <div class="mt-auto" ></div>

            <ul class="navbar-nav mb-md-4">
                <li class="nav-item">
                    <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        تسجيل الخروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div> <!-- / .navbar-collapse -->
    </div>
</nav>
