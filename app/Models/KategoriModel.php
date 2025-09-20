<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    // Nama tabel yang akan digunakan oleh model ini
    protected $table = 'kategori'; 

    // Primary key dari tabel
    protected $primaryKey = 'id'; 

    // Kolom mana saja yang diizinkan untuk diisi atau diubah
    protected $allowedFields = ['nama_kategori', 'tipe', 'anggaran', 'user_id']; 


    // Anda bisa menambahkan fungsi custom di sini jika perlu
    // Contoh: fungsi untuk mengambil kategori pengeluaran saja
    public function getKategoriPengeluaran()
    {
        return $this->where('tipe', 'pengeluaran')->findAll();
    }
}