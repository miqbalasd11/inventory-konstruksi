<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('email', [
            'admin@example.com',
            'gudang@example.com',
            'proyek@example.com',
            'manager@example.com',
        ])->get();

        foreach ($users as $user) {
            Notification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'judul' => 'Selamat datang di sistem inventory',
                ],
                [
                    'pesan' => 'Akun Anda telah dibuat dan siap digunakan. Silakan cek data master dan transaksi.',
                    'is_read' => false,
                ]
            );

            Notification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'judul' => 'Notifikasi stok rendah',
                ],
                [
                    'pesan' => 'Periksa stok barang yang berada di bawah stok minimum agar tidak terjadi kekosongan.',
                    'is_read' => false,
                ]
            );
        }
    }
}
