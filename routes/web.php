<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\ApprovalMaterialRequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    $role = Auth::user()->role?->name ?? '';

    if ($role === 'Super Admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'Admin Gudang') {
        return redirect()->route('gudang.dashboard');
    }

    if ($role === 'Staff Proyek') {
        return redirect()->route('lapangan.dashboard');
    }

    if ($role === 'Manajer Proyek') {
        return redirect()->route('manager.dashboard');
    }

    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('purchase-orders', PurchaseOrderController::class);

    /*
    |--------------------------------------------------------------------------
    | Dashboard Role
    |--------------------------------------------------------------------------
    */

    Route::get('/admin', [DashboardController::class, 'index'])
        ->middleware('role:Super Admin')
        ->name('admin.dashboard');

    Route::get('/gudang', function () {
        return view('dashboard.gudang');
    })->middleware('role:Admin Gudang')
        ->name('gudang.dashboard');

    Route::get('/dashboard-lapangan', [DashboardController::class, 'lapangan'])
        ->middleware('role:Staff Proyek|Staff Lapangan')
        ->name('lapangan.dashboard');

    Route::get('/manager', [DashboardController::class, 'manager'])
        ->middleware('role:Manajer Proyek|Manager Proyek|Manager')
        ->name('manager.dashboard');

    Route::middleware(['auth', 'role:Super Admin,Admin Gudang'])->group(function () {
        // Route AJAX untuk mengambil detail Purchase Order
        Route::get('/purchase-order/{id}/detail', [BarangMasukController::class, 'getPoDetail'])
            ->name('purchase-order.detail');
    });
    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Super Admin')->group(function () {

        Route::resource('kategori', KategoriController::class);

        Route::resource('satuan', SatuanController::class);

        Route::resource('supplier', SupplierController::class);

        Route::resource('barang', BarangController::class);

        Route::resource('proyek', ProyekController::class);

        Route::resource('users', UserController::class);

        Route::resource('permintaan-barang', PermintaanBarangController::class);

        Route::get(
            '/satuan/ajax/{kode}',
            [SatuanController::class, 'getByKode']
        )->name('satuan.ajax');

        Route::get(
            '/activity-log',
            [ActivityLogController::class, 'index']
        )->name('activity-log.index');

        Route::get(
            '/purchase-orders/create-from-mr/{mr}',
            [PurchaseOrderController::class, 'createFromMR']
        )->name('purchase-orders.createFromMR');

        Route::resource(
            'purchase-orders',
            PurchaseOrderController::class
        );
    });
    Route::post(
        '/purchase-orders/{purchaseOrder}/kirim',
        [PurchaseOrderController::class, 'kirim']
    )->name('purchase-orders.kirim');
    /*
    |--------------------------------------------------------------------------
    | ADMIN GUDANG
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Super Admin|Admin Gudang')->group(function () {

        Route::resource(
            'barang-masuk',
            BarangMasukController::class
        );

        Route::get(
            '/barang-masuk/{barangMasuk}/edit',
            [BarangMasukController::class, 'edit']
        )->name('barang-masuk.edit');

        Route::put(
            '/barang-masuk/{barangMasuk}',
            [BarangMasukController::class, 'update']
        )->name('barang-masuk.update');

        Route::resource(
            'barang-keluar',
            BarangKeluarController::class
        );
    });

    /*
    |--------------------------------------------------------------------------
    | PERMINTAAN BARANG
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Super Admin|Admin Gudang|Staff Proyek|Staff Lapangan|Manajer Proyek|Manager Proyek'])->group(function () {

        Route::get(
            '/permintaan-barang',
            [PermintaanBarangController::class, 'index']
        )->name('permintaan-barang.index');

        Route::get(
            '/permintaan-barang/{permintaan_barang}',
            [PermintaanBarangController::class, 'show']
        )
            ->whereNumber('permintaan_barang')
            ->name('permintaan-barang.show');
    });

    Route::middleware(['role:Super Admin|Staff Proyek|Staff Lapangan'])->group(function () {

        Route::resource(
            'permintaan-barang',
            PermintaanBarangController::class
        )->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
    });

    Route::middleware(['role:Super Admin|Manajer Proyek|Manager Proyek|Manager'])->group(function () {

        Route::post(
            '/permintaan-barang/{permintaan_barang}/approve',
            [PermintaanBarangController::class, 'approve']
        )->name('permintaan.approve');

        Route::post(
            '/permintaan-barang/{permintaan_barang}/reject',
            [PermintaanBarangController::class, 'reject']
        )->name('permintaan.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | LAPORAN (SEMUA ROLE)
    |--------------------------------------------------------------------------
    */

    Route::prefix('laporan')->group(function () {

        Route::get('/stok', [
            LaporanController::class,
            'stok',
        ])->name('laporan.stok');

        Route::get('/barang-masuk', [
            LaporanController::class,
            'barangMasuk',
        ])->name('laporan.barang-masuk');

        Route::get('/barang-keluar', [
            LaporanController::class,
            'barangKeluar',
        ])->name('laporan.barang-keluar');

        Route::get('/proyek', [
            LaporanController::class,
            'proyek',
        ])->name('laporan.proyek');

        Route::get('/permintaan', [
            LaporanController::class,
            'permintaan',
        ])->name('laporan.permintaan');

        Route::get(
            '/kartu-stok',
            [LaporanController::class, 'kartuStok']
        )->name('laporan.kartu-stok');

        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        Route::get('/stok/pdf', [
            LaporanController::class,
            'pdfStok',
        ])->name('laporan.stok.pdf');

        Route::get('/barang-masuk/pdf', [
            LaporanController::class,
            'pdfBarangMasuk',
        ])->name('laporan.barang-masuk.pdf');

        Route::get('/barang-keluar/pdf', [
            LaporanController::class,
            'pdfBarangKeluar',
        ])->name('laporan.barang-keluar.pdf');

        Route::get('/proyek/pdf', [
            LaporanController::class,
            'pdfProyek',
        ])->name('laporan.proyek.pdf');

        Route::get('/permintaan/pdf', [
            LaporanController::class,
            'pdfPermintaan',
        ])->name('laporan.permintaan.pdf');

        Route::get('/kartu-stok/pdf', [
            LaporanController::class,
            'pdfKartuStok',
        ])->name('laporan.kartu-stok.pdf');

        Route::get(
            '/stok/export',
            [LaporanController::class, 'exportStok']
        )->name('laporan.stok.export');

        Route::get(
            '/barang-masuk/export',
            [LaporanController::class, 'exportBarangMasuk']
        )->name('laporan.barang-masuk.export');

        Route::get(
            '/barang-keluar/export',
            [LaporanController::class, 'exportBarangKeluar']
        )->name('laporan.barang-keluar.export');

        Route::get(
            '/proyek/export',
            [LaporanController::class, 'exportProyek']
        )->name('laporan.proyek.export');

        Route::get(
            '/permintaan/export',
            [LaporanController::class, 'exportPermintaan']
        )->name('laporan.permintaan.export');

        Route::get(
            '/kartu-stok/export',
            [LaporanController::class, 'exportKartuStok']
        )->name('laporan.kartu-stok.export');

         /*
        |--------------------------------------------------------------------------
        | MATERIAL REQUEST
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/material-request',
            [LaporanController::class, 'materialRequest']
        )->name('laporan.material-request');

        Route::get(
            '/material-request/pdf',
            [LaporanController::class, 'pdfMaterialRequest']
        )->name('laporan.material-request.pdf');

        Route::get(
            '/material-request/export',
            [LaporanController::class, 'exportMaterialRequest']
        )->name('laporan.material-request.export');

        /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/purchase-order',
            [LaporanController::class, 'purchaseOrder']
        )->name('laporan.purchase-order');

        Route::get(
            '/purchase-order/pdf',
            [LaporanController::class, 'pdfPurchaseOrder']
        )->name('laporan.purchase-order.pdf');

        Route::get(
            '/purchase-order/export',
            [LaporanController::class, 'exportPurchaseOrder']
        )->name('laporan.purchase-order.export');

        /*
        |--------------------------------------------------------------------------
        | SUPPLIER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/supplier',
            [LaporanController::class, 'supplier']
        )->name('laporan.supplier');

        Route::get(
            '/supplier/pdf',
            [LaporanController::class, 'pdfSupplier']
        )->name('laporan.supplier.pdf');

        Route::get(
            '/supplier/export',
            [LaporanController::class, 'exportSupplier']
        )->name('laporan.supplier.export');

    });

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications.index');

    Route::post(
        '/notifications/{id}/read',
        [NotificationController::class, 'read']
    )->name('notifications.read');

    Route::resource(
        'material-request',
        MaterialRequestController::class
    );

    Route::prefix('approval')
        ->middleware('auth')
        ->group(function () {

            Route::get(
                '/material-request',
                [ApprovalMaterialRequestController::class, 'index']
            )->name('approval.index');

            Route::get(
                '/material-request/{id}',
                [ApprovalMaterialRequestController::class, 'show']
            )->name('approval.show');

            Route::post(
                '/material-request/{id}/approve',
                [ApprovalMaterialRequestController::class, 'approve']
            )->name('approval.approve');

            Route::post(
                '/material-request/{id}/reject',
                [ApprovalMaterialRequestController::class, 'reject']
            )->name('approval.reject');
        });
});

require __DIR__ . '/auth.php';
