<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex h-auto p-0 align-items-center " href="{{ route('home') }}">
        <div class="sidebar-brand-icon text-left p-3">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text text-left">Sepatu Bersih</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if($user->role == 'admin')
    <!-- Nav Item - Dashboard -->
    <x-nav-item :href="route('admin.dashboard')">
        <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
    </x-nav-item>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pesanan 
    </div>

    <x-nav-item :href="route('order.make')">
        <i class="fas fa-fw fa-pen"></i>
            <span>Buat Pesanan</span>
    </x-nav-item>
    <x-nav-item :href="route('order.process')">
        <i class="fas fa-fw fa-table"></i>
            <span>Pesanan Diproses</span>
    </x-nav-item>
    <x-nav-item :href="route('order.done')">
        <i class="fas fa-fw fa-table"></i>
            <span>Pesanan Selesai</span>
    </x-nav-item>
    <x-nav-item :href="route('order.all')">
        <i class="fas fa-fw fa-table"></i>
            <span>Semua Pesanan</span>
    </x-nav-item>

    @can(['edit-employee', 'edit-service'])
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data 
    </div>

    @can('edit-employee')
    <x-nav-item :href="route('karyawan.view')">
        <i class="fas fa-fw fa-table"></i>
        <span>Karyawan</span>
    </x-nav-item>
    @endcan

    @can('edit-service')
    <x-nav-item :href="route('layanan.view')">
        <i class="fas fa-fw fa-table"></i>
        <span>Layanan</span>
    </x-nav-item>
    @endcan

    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
