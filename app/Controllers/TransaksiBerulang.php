<?php
namespace App\Controllers;

use App\Models\TransaksiBerulangModel;
use App\Models\KategoriModel;

class TransaksiBerulang extends BaseController
{
    public function index()
    {
        $model = new TransaksiBerulangModel();
        $kategoriModel = new KategoriModel();
        $userId = session()->get('userId');

        $data['aturan'] = $model->where('user_id', $userId)->findAll();
        $data['kategori'] = $kategoriModel->where('user_id', $userId)->findAll();

        return view('transaksi_berulang/index', $data);
    }

    public function store()
    {
        $model = new TransaksiBerulangModel();
        $data = [
            'user_id'       => session()->get('userId'),
            'id_kategori'   => $this->request->getPost('id_kategori'),
            'jumlah'        => $this->request->getPost('jumlah'),
            'tipe'          => $this->request->getPost('tipe'),
            'keterangan'    => $this->request->getPost('keterangan'),
            'frekuensi'     => $this->request->getPost('frekuensi'),
            'hari_eksekusi' => $this->request->getPost('hari_eksekusi'),
            // Awalnya, kita set tanggal eksekusi terakhir ke masa lalu
            'terakhir_eksekusi' => '1970-01-01' 
        ];
        $model->save($data);
        session()->setFlashdata('pesan', 'Aturan transaksi berulang berhasil ditambahkan.');
        return redirect()->to('/transaksi-berulang');
    }

    public function delete($id)
    {
        $model = new TransaksiBerulangModel();
        // Lakukan pengecekan kepemilikan sebelum menghapus
        $aturan = $model->find($id);
        if ($aturan && $aturan['user_id'] == session()->get('userId')) {
            $model->delete($id);
            session()->setFlashdata('pesan', 'Aturan berhasil dihapus.');
        }
        return redirect()->to('/transaksi-berulang');
    }

    // Di dalam file app/Controllers/TransaksiBerulang.php

    public function execute()
    {
        $aturanModel = new \App\Models\TransaksiBerulangModel();
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