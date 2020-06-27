<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-adjust"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Wakaf Zakat</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{Request::is('dashboard')? 'active':''}}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/mitra')? 'active':''}}">
        <a class="nav-link" href="{{route('mitra.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Mitra</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @hasanyrole('superadmin|admin')
    <!-- Heading -->
    <div class="sidebar-heading">
        Users & Roles Management
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/roles-permissions') || Request::is('dashboard/users')? 'active':''}}">
        <a class="nav-link {{Request::is('dashboard/roles-permissions') || Request::is('dashboard/users')? '':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Users & Roles</span>
        </a>
        <div id="collapsePages" class="collapse {{Request::is('dashboard/roles-permissions') || Request::is('dashboard/users')? 'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('dashboard/roles-permissions')? 'active':''}}" href="{{route('roles-permissions.index')}}">Roles & Permissions</a>
                <a class="collapse-item {{Request::is('dashboard/users')? 'active':''}}" href="{{route('users.index')}}">Users</a>
            </div>
        </div>
    </li>
    @endhasanyrole

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>