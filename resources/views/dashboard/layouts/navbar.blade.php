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
                <img src="./assets/img/logo.svg" class="navbar-brand-img
          mx-auto">
            </div>
            <div class="title-header">متجر iPaw Store</div>
        </div>

        <!-- User (xs) -->
        <div class="navbar-user d-md-none">

            <!-- Dropdown -->
            <div class="dropdown">

                <!-- Toggle -->
                <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-sm avatar-online">
                        <img src="./assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
                    </div>
                </a>

                <!-- Menu -->
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
                    <a href="./profile-posts.html" class="dropdown-item">Profile</a>
                    <a href="./account-general.html" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider">
                    <a href="./sign-in.html" class="dropdown-item">Logout</a>
                </div>

            </div>

        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">

            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fe fe-search"></span>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Home -->
            <ul class="navbar-nav" >
                <li class="nav-item" style="margin-top: 20px">
                    <a class="nav-link" href="#">
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
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-friends"></i> <span class="title-link"> المشتركين </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
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
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-plus"></i> <span class="title-link"> الطلبات </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-receipt"></i> <span class="title-link"> الفواتير </span>
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
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell"></i> <span class="title-link"> الاشعارات </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-credit-card"></i> <span class="title-link"> طرق الدفع </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-toolbox"></i> <span class="title-link"> الاضافات </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-cogs"></i> <span class="title-link"> الاعدادات العامة </span>
                    </a>
                </li>

            </ul>

            <!-- Push content down -->
            <div class="mt-auto" ></div>




            <!-- User (md) -->
            <div class="navbar-user d-none d-md-flex" id="sidebarUser">

                <!-- Icon -->
                <a href="#sidebarModalActivity" class="navbar-user-link" data-toggle="modal">
              <span class="icon">
                <i class="fe fe-bell"></i>
              </span>
                </a>

                <!-- Dropup -->
                <div class="dropup">

                    <!-- Toggle -->
                    <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="./assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                        <a href="./profile-posts.html" class="dropdown-item">Profile</a>
                        <a href="./account-general.html" class="dropdown-item">Settings</a>
                        <hr class="dropdown-divider">
                        <a href="./sign-in.html" class="dropdown-item">Logout</a>
                    </div>

                </div>

                <!-- Icon -->
                <a href="#sidebarModalSearch" class="navbar-user-link" data-toggle="modal">
              <span class="icon">
                <i class="fe fe-search"></i>
              </span>
                </a>

            </div>


        </div> <!-- / .navbar-collapse -->

    </div>
</nav>
