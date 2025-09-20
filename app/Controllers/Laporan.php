<?php
namespace App\Controllers;

use App\Models\TransaksiModel;

class Laporan extends BaseController
{
    // Di dalam file app/Controllers/Laporan.php
    public function index()
    {
        $transaksiModel = new TransaksiModel();
        $data['title'] = 'Laporan Keuangan';

        // Ambil data bulan dan tahun DARI SINI
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        // Jika ada data bulan dan tahun (form sudah disubmit)
        if ($bulan && $tahun) {
            $data['ringkasan'] = $transaksiModel->getRingkasan($bulan, $tahun);
            // Kirim kembali bulan dan tahun yang dipilih ke view
            $data['bulan_terpilih'] = $bulan;
            $data['tahun_terpilih'] = $tahun;
        }

        return view('laporan', $data);
    }
}