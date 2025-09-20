<?php

namespace App\Controllers;

use App\Models\TransaksiModel; // <-- PASTIKAN BARIS INI ADA

class Dashboard extends BaseController
{
    // Di dalam file app/Controllers/Dashboard.php

// Di dalam file app/Controllers/Dashboard.php

    public function index()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        
        // 1. Logika Filter Tanggal
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');
        }

        // 2. Ambil Semua Data dari Model
        $ringkasan = $transaksiModel->getRingkasanByDateRange($startDate, $endDate);
        $chartData = $transaksiModel->getPengeluaranPerKategoriByDateRange($startDate, $endDate);
        $progressAnggaran = $transaksiModel->getAnggaranProgress(); // Catatan: ini masih data bulan ini

        // 3. Siapkan Array Data Awal
        $data = [
            'total_pemasukan'   => $ringkasan['pemasukan'],
            'total_pengeluaran'  => $ringkasan['pengeluaran'],
            'saldo'              => $ringkasan['pemasukan'] - $ringkasan['pengeluaran'],
            'chart_data'         => $chartData,
            'progress_anggaran'  => $progressAnggaran,
            'start_date'         => $startDate,
            'end_date'           => $endDate
        ];

        // 4. Buat Logika Saran Finansial
        $saran = '';
        if ($data['saldo'] < 0) {
            $saran = "Peringatan! Pengeluaran Anda pada periode ini melebihi pemasukan.";
        } elseif ($data['saldo'] > 0) {
            $saran = "Kerja bagus! Anda berhasil menghemat Rp " . number_format($data['saldo'], 0, ',', '.') . " pada periode ini.";
        } else {
            $saran = "Kondisi keuangan Anda seimbang pada periode ini.";
        }
        
        // 5. Tambahkan Saran ke Array Data
        $data['saran_finansial'] = $saran;

        // 6. Tampilkan View
        return view('dashboard', $data);
    }

}