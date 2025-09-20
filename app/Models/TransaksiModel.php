<?php
namespace App\Models;
use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    // PERBAIKAN 1: Tambahkan 'user_id' di sini
    protected $allowedFields = ['id_kategori', 'jumlah', 'tipe', 'keterangan', 'tanggal', 'user_id'];

        public function getRingkasan($bulan, $tahun)
        {
            $userId = session()->get('userId');

            $pemasukan = $this->selectSum('jumlah')
                            ->where('tipe', 'pemasukan')
                            ->where("MONTH(tanggal)", $bulan)
                            ->where("YEAR(tanggal)", $tahun)
                            ->where('user_id', $userId) // Lebih bersih
                            ->get()->getRow()->jumlah;
                            
            $pengeluaran = $this->selectSum('jumlah')
                            ->where('tipe', 'pengeluaran')
                            ->where("MONTH(tanggal)", $bulan)
                            ->where("YEAR(tanggal)", $tahun)
                            ->where('user_id', $userId) // Lebih bersih
                            ->get()->getRow()->jumlah;
            
            return [
                'pemasukan'   => $pemasukan ?? 0,
                'pengeluaran' => $pengeluaran ?? 0
            ];
        }

    public function getPengeluaranPerKategori()
    {
        $userId = session()->get('userId');
        $bulan = date('m');
        $tahun = date('Y');

        return $this->select('kategori.nama_kategori, SUM(transaksi.jumlah) as total')
                    ->join('kategori', 'kategori.id = transaksi.id_kategori')
                    ->where('transaksi.tipe', 'pengeluaran')
                    ->where('MONTH(transaksi.tanggal)', $bulan)
                    ->where('YEAR(transaksi.tanggal)', $tahun)
                    // PERBAIKAN 2: Filter transaksi dan kategori berdasarkan user
                    ->where('transaksi.user_id', $userId)
                    ->where('kategori.user_id', $userId)
                    ->groupBy('kategori.nama_kategori')
                    ->findAll();
    }

    public function getAnggaranProgress()
    {
        $userId = session()->get('userId');
        $bulan = date('m');
        $tahun = date('Y');

        // PERBAIKAN 3: Query yang lebih akurat dan aman
        return $this->db->table('kategori')
            ->select('kategori.nama_kategori, kategori.anggaran, SUM(transaksi.jumlah) as total_pengeluaran')
            // Pindahkan filter transaksi.user_id ke dalam JOIN
            ->join('transaksi', 'transaksi.id_kategori = kategori.id AND transaksi.user_id = '.$userId, 'left')
            // Filter utama harus pada kategori milik user
            ->where('kategori.user_id', $userId) 
            ->where('kategori.tipe', 'pengeluaran')
            ->where('kategori.anggaran >', 0)
            ->groupStart()
                ->where('MONTH(transaksi.tanggal)', $bulan)
                ->where('YEAR(transaksi.tanggal)', $tahun)
                ->orWhere('transaksi.tanggal IS NULL')
            ->groupEnd()
            ->groupBy('kategori.id')
            ->get()->getResultArray();
    }
    public function getRingkasanByDateRange($startDate, $endDate)
    {
            $userId = session()->get('userId');

            $pemasukan = $this->selectSum('jumlah')
                            ->where('tipe', 'pemasukan')
                            ->where('user_id', $userId)
                            ->where('tanggal >=', $startDate)
                            ->where('tanggal <=', $endDate)
                            ->get()->getRow()->jumlah;
                            
            $pengeluaran = $this->selectSum('jumlah')
                            ->where('tipe', 'pengeluaran')
                            ->where('user_id', $userId)
                            ->where('tanggal >=', $startDate)
                            ->where('tanggal <=', $endDate)
                            ->get()->getRow()->jumlah;
            
            return [
                'pemasukan'   => $pemasukan ?? 0,
                'pengeluaran' => $pengeluaran ?? 0
            ];
        }

        public function getPengeluaranPerKategoriByDateRange($startDate, $endDate)
        {
            $userId = session()->get('userId');

            return $this->select('kategori.nama_kategori, SUM(transaksi.jumlah) as total')
                        ->join('kategori', 'kategori.id = transaksi.id_kategori')
                        ->where('transaksi.tipe', 'pengeluaran')
                        ->where('transaksi.user_id', $userId)
                        ->where('kategori.user_id', $userId)
                        ->where('transaksi.tanggal >=', $startDate)
                        // --- PERBAIKAN DI SINI ---
                        ->where('transaksi.tanggal <=', $endDate)
                        ->groupBy('kategori.nama_kategori')
                        ->findAll();
        }
    }