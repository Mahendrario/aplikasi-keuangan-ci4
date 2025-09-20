<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- PEMASUKAN ---
            ['nama_kategori' => 'Gaji', 'tipe' => 'pemasukan', 'anggaran' => 0],
            ['nama_kategori' => 'Bonus', 'tipe' => 'pemasukan', 'anggaran' => 0],
            ['nama_kategori' => 'Usaha Sampingan', 'tipe' => 'pemasukan', 'anggaran' => 0],
            ['nama_kategori' => 'Hadiah', 'tipe' => 'pemasukan', 'anggaran' => 0],
            
            // --- PENGELUARAN ---
            // Kebutuhan Pokok
            ['nama_kategori' => 'Belanja Bulanan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Tagihan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Transportasi', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Cicilan / Hutang', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            // Gaya Hidup
            ['nama_kategori' => 'Makan di Luar / Jajan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Hiburan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Hobi', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Belanja Pakaian', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Liburan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            // Lain-lain
            ['nama_kategori' => 'Kesehatan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Pendidikan', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Donasi / Sosial', 'tipe' => 'pengeluaran', 'anggaran' => 0],
            ['nama_kategori' => 'Lainnya', 'tipe' => 'pengeluaran', 'anggaran' => 0],
        ];

        // Menggunakan Query Builder untuk memasukkan semua data sekaligus
        $this->db->table('kategori')->insertBatch($data);
    }
}