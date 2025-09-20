<?php
namespace App\Models;
use CodeIgniter\Model;

class TransaksiBerulangModel extends Model
{
    protected $table = 'transaksi_berulang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'id_kategori', 'jumlah', 'tipe', 
        'keterangan', 'frekuensi', 'hari_eksekusi', 'terakhir_eksekusi'
    ];
    public function execute()
    {
        $aturanModel = new TransaksiBerulangModel();
        $transaksiModel = new \App\Models\TransaksiModel();
        $userId = session()->get('userId');

        $aturan_list = $aturanModel->where('user_id', $userId)->findAll();
        $transaksi_baru = 0;

        foreach ($aturan_list as $aturan) {
            $jalankan = false;
            // Logika untuk bulanan
            if ($aturan['frekuensi'] == 'bulanan') {
                $tgl_eksekusi_bulan_ini = date('Y-m-') . str_pad($aturan['hari_eksekusi'], 2, '0', STR_PAD_LEFT);
                if (date('Y-m-d') >= $tgl_eksekusi_bulan_ini && $aturan['terakhir_eksekusi'] < $tgl_eksekusi_bulan_ini) {
                    $jalankan = true;
                }
            }
            // (Logika untuk mingguan bisa ditambahkan di sini)

            if ($jalankan) {
                // Buat transaksi baru
                $transaksiModel->save([
                    'user_id'       => $userId,
                    'id_kategori'   => $aturan['id_kategori'],
                    'jumlah'        => $aturan['jumlah'],
                    'tipe'          => $aturan['tipe'],
                    'keterangan'    => $aturan['keterangan'] . " (Otomatis)",
                    'tanggal'       => date('Y-m-d')
                ]);
                // Update tanggal eksekusi terakhir
                $aturanModel->update($aturan['id'], ['terakhir_eksekusi' => date('Y-m-d')]);
                $transaksi_baru++;
            }
        }
        
        session()->setFlashdata('pesan', $transaksi_baru . ' transaksi rutin berhasil dijalankan.');
        return redirect()->to('/'); // Kembali ke dashboard
    }
}
