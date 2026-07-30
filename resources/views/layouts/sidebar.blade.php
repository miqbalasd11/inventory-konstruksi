```blade
<div class="sidebar">

    {{-- Logo --}}
    <div class="sidebar-header">

        <div class="logo">
            <i class="bi bi-buildings-fill"></i>
        </div>

        <div>
            <h6 class="mb-0 fw-bold">
                Inventory
            </h6>
            <small>
                Construction ERP
            </small>
        </div>

    </div>

    @php
    $role = strtolower(trim(auth()->user()?->role?->name ?? ''));

    $isSuperAdmin = $role === 'super admin';
    $isAdminGudang = $role === 'admin gudang';
    $isStaffProyek = in_array($role, ['staff proyek', 'staff lapangan'], true);
    $isManajerProyek = in_array($role, ['manajer proyek', 'manager proyek'], true);

    if ($isSuperAdmin) {
    $dashboardRoute = 'admin.dashboard';
    $dashboardLabel = 'Dashboard Admin';
    } elseif ($isAdminGudang) {
    $dashboardRoute = 'gudang.dashboard';
    $dashboardLabel = 'Dashboard Gudang';
    } elseif ($isStaffProyek) {
    $dashboardRoute = 'lapangan.dashboard';
    $dashboardLabel = 'Dashboard Proyek';
    } elseif ($isManajerProyek) {
    $dashboardRoute = 'manager.dashboard';
    $dashboardLabel = 'Dashboard Manajer';
    } else {
    $dashboardRoute = 'dashboard';
    $dashboardLabel = 'Dashboard';
    }
    @endphp

    <ul class="nav flex-column sidebar-menu">

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a href="{{ route($dashboardRoute) }}"
                class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>{{ $dashboardLabel }}</span>
            </a>
        </li>

        {{-- SUPER ADMIN --}}
        @if($isSuperAdmin)

        <div class="menu-title">
            ADMINISTRATOR
        </div>

        <li class="nav-item">
            <a href="{{ route('users.index') }}"
                class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen User</span>
            </a>
        </li>

        <div class="menu-title">
            MASTER DATA
        </div>

        <li class="nav-item">
            <a href="{{ route('kategori.index') }}"
                class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('barang.index') }}"
                class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('satuan.index') }}"
                class="nav-link {{ request()->routeIs('satuan.*') ? 'active' : '' }}">
                <i class="bi bi-rulers"></i>
                <span>Satuan</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('supplier.index') }}"
                class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                <span>Supplier</span>
            </a>
        </li>

        <div class="menu-title">
            OPERASIONAL
        </div>

        <li class="nav-item">
            <a href="{{ route('proyek.index') }}"
                class="nav-link {{ request()->routeIs('proyek.*') ? 'active' : '' }}">
                <i class="bi bi-building-fill"></i>
                <span>Proyek</span>
            </a>
        </li>

        @endif

        {{-- TRANSAKSI --}}
        @if($isSuperAdmin || $isAdminGudang)

        <div class="menu-title">
            TRANSAKSI
        </div>

        <li class="nav-item">
            <a href="{{ route('barang-masuk.index') }}"
                class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>Barang Masuk</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('barang-keluar.index') }}"
                class="nav-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i>
                <span>Barang Keluar</span>
            </a>
        </li>

        @endif

        @if($isSuperAdmin || $isAdminGudang || $isStaffProyek || $isManajerProyek)

        <div class="menu-title">
            OPERASIONAL
        </div>

        <!-- TRANSAKSI -->

        <li class="nav-item">
            <a href="{{ route('material-request.index') }}"
                class="nav-link {{ request()->routeIs('material-request.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Material Request</span>
            </a>
        </li>

        <!-- APPROVAL -->

        <li class="nav-item">
            <a href="{{ route('approval.index') }}"
                class="nav-link {{ request()->routeIs('approval.*') ? 'active' : '' }}">
                <i class="bi bi-check-circle-fill"></i>
                <span>Approval MR</span>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('permintaan-barang.index') }}"
                class="nav-link {{ request()->routeIs('permintaan-barang.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                <span>Permintaan Barang</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('purchase-orders.index') }}"
                class="nav-link {{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}">
                <i class="bi bi-cart-check-fill"></i>
                <span>Purchase Order</span>
            </a>
        </li>

        @endif

        @if($isSuperAdmin || $isAdminGudang || $isManajerProyek)

        <div class="menu-title">
            LAPORAN
        </div>

        @if($isSuperAdmin || $isAdminGudang || $isManajerProyek)

        <li class="nav-item">
            <a href="{{ route('laporan.stok') }}"
                class="nav-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                <i class="bi bi-archive-fill"></i>
                <span>Laporan Stok</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.barang-masuk') }}"
                class="nav-link {{ request()->routeIs('laporan.barang-masuk') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-arrow-down-fill"></i>
                <span>Laporan Barang Masuk</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.barang-keluar') }}"
                class="nav-link {{ request()->routeIs('laporan.barang-keluar') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-arrow-up-fill"></i>
                <span>Laporan Barang Keluar</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporan.material-request') }}"
                class="nav-link {{ request()->routeIs('laporan.material-request') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-medical-fill"></i>
                <span>Laporan Material Request</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.purchase-order') }}"
                class="nav-link {{ request()->routeIs('laporan.purchase-order') ? 'active' : '' }}">
                <i class="bi bi-cart4"></i>
                <span>Laporan Purchase Order</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.supplier') }}"
                class="nav-link {{ request()->routeIs('laporan.supplier') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                <span>Laporan Supplier</span>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a href="{{ route('laporan.proyek') }}"
                class="nav-link {{ request()->routeIs('laporan.proyek') ? 'active' : '' }}">
                <i class="bi bi-building-gear"></i>
                <span>Material Proyek</span>
            </a>
        </li>

        @if($isSuperAdmin || $isAdminGudang || $isManajerProyek)

        <li class="nav-item">
            <a href="{{ route('laporan.permintaan') }}"
                class="nav-link {{ request()->routeIs('laporan.permintaan') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Laporan Permintaan</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.kartu-stok') }}"
                class="nav-link {{ request()->routeIs('laporan.kartu-stok') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                <span>Kartu Stok</span>
            </a>
        </li>

        @endif

        @endif

        {{-- SYSTEM --}}
        <div class="menu-title">
            SYSTEM
        </div>

        <li class="nav-item">
            <a href="{{ route('notifications.index') }}"
                class="nav-link">
                <i class="bi bi-bell-fill"></i>
                <span>Notifikasi</span>
            </a>
        </li>

        @if($isSuperAdmin)

        <li class="nav-item">
            <a href="{{ route('activity-log.index') }}"
                class="nav-link">
                <i class="bi bi-clock-history"></i>
                <span>Audit Trail</span>
            </a>
        </li>

        @endif

    </ul>

</div>
```