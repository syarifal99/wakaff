<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-text mx-3">
        <img width="50 px"src="{{asset('assets/img/logo.png') }}">
        Wakaf</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{Request::is('dashboard')? 'active':''}}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @hasanyrole('mitra')

    {{-- <div class="sidebar-heading">
        Grafik
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/mitra')? 'active':''}}">
        <a class="nav-link" href="{{route('mitra.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Grafik</span></a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/project')? 'active':''}}">
             <a class="nav-link" href="{{route('project.index')}}">
                 <i class="fas fa-fw fa-clipboard"></i>
                 <span>Project</span></a>
    </li> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/pendanaan') || Request::is('dashboard/aset')? 'active':''}}">
        <a class="nav-link {{Request::is('dashboard/pendanaan') || Request::is('dashboard/aset')? '':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Donasi</span>
        </a>
        <div id="collapsePages" class="collapse {{Request::is('dashboard/pendanaan') || Request::is('dashboard/pendanaan/aset/yoii')? 'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('dashboard/pendanaan')? 'active':''}}" href="{{route('pendanaan.index')}}">Wakaf Tunai</a>
                <a class="collapse-item {{Request::is('dashboard/pendanaan/aset/yoii')? 'active':''}}" href="{{route('pendanaan.aset')}}">Wakaf Aset</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>
    
        <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/project')? 'active':''}}">
             <a class="nav-link" href="{{route('project.index')}}">
                 <i class="fas fa-fw fa-clipboard"></i>
                 <span>Project</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/progres') || Request::is('dashboard/paset')? 'active':''}}">
        <a class="nav-link {{Request::is('dashboard/progres') || Request::is('dashboard/paset')? '':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true"
            aria-controls="collapsePages2">
            <i class="fas fa-fw fa-info"></i>
            <span>Progres Project</span>
        </a>
        <div id="collapsePages2" class="collapse {{Request::is('dashboard/progres') || Request::is('dashboard/progresaset')? 'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('dashboard/progres')? 'active':''}}" href="{{route('progres.index')}}">Progres Tunai</a>
                <a class="collapse-item {{Request::is('dashboard/progresaset')? 'active':''}}" href="{{route('progres.aset')}}">Progres Aset</a>
            </div>
        </div>
    </li>

    @endhasanyrole
    
    @hasanyrole('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/pendanaan') || Request::is('dashboard/aset')? 'active':''}}">
        <a class="nav-link {{Request::is('dashboard/pendanaan') || Request::is('dashboard/aset')? '':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Donasi</span>
        </a>
        <div id="collapsePages" class="collapse {{Request::is('dashboard/pendanaan') || Request::is('dashboard/pendanaan/aset/yoii')? 'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('dashboard/pendanaan')? 'active':''}}" href="{{route('pendanaan.index')}}">Wakaf Tunai</a>
                <a class="collapse-item {{Request::is('dashboard/pendanaan/aset/yoii')? 'active':''}}" href="{{route('pendanaan.aset')}}">Wakaf Aset</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/mitra')? 'active':''}}">
        <a class="nav-link" href="{{route('mitra.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>Mitra</span></a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/project')? 'active':''}}">
             <a class="nav-link" href="{{route('project.index')}}">
                 <i class="fas fa-fw fa-clipboard"></i>
                 <span>Project</span></a>
    </li>
    
    <li class="nav-item {{Request::is('dashboard/pencairan')? 'active':''}}">
             <a class="nav-link" href="{{route('pencairan.index')}}">
                 <i class="fas fa-fw fa-dollar-sign"></i>
                 <span>Pencairan</span></a>
    </li>
    <li class="nav-item {{Request::is('dashboard/monitoring')? 'active':''}}">
             <a class="nav-link" href="{{route('monitoring.index')}}">
                 <i class="fas fa-fw fa-user"></i>
                 <span>Monitoring Mitra</span></a>
    </li>
    @endhasanyrole
    
    @hasanyrole('superadmin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{Request::is('dashboard/mitra')? 'active':''}}">
        <a class="nav-link" href="{{route('mitra.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>Mitra</span></a>
    </li>

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