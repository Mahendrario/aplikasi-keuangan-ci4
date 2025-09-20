<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\KategoriModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $transaksiModel = new TransaksiModel();
        $kategoriModel = new KategoriModel();
        $userId = session()->get('userId');

        // --- PERUBAHAN DIMULAI DI SINI ---

        // 1. Ambil keyword pencarian dari URL (menggunakan metode GET)
        $keyword = $this->request->getGet('keyword');

        // 2. Siapkan query dasar yang sudah difilter berdasarkan user
        $query = $transaksiModel->where('user_id', $userId);

        // 3. Jika ada keyword, tambahkan kondisi "like" untuk pencarian
        if ($keyword) {
            $query->like('keterangan', $keyword);
        }

        // 4. Eksekusi query dan kirim data ke view
        $data['transaksi'] = $query->findAll();
        $data['kategori'] = $kategoriModel->where('user_id', $userId)->findAll();
        $data['keyword'] = $keyword; // Kirim keyword kembali ke view untuk ditampilkan di form

        // --- AKHIR PERUBAHAN ---

        return view('transaksi/index', $data);
    }

    public function store()
    {
        // Tambahkan validasi untuk keamanan data
        $rules = [
            'tanggal'     => 'required',
            'jumlah'      => 'required|numeric',
            'id_kategori' => 'required'
        ];
        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $transaksiModel = new TransaksiModel();

        // --- PERUBAHAN DI SINI ---
        $data = [
            'tanggal'     => $this->request->getPost('tanggal'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'tipe'        => $this->request->getPost('tipe'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'keterangan'  => $this->request->getPost('keterangan'),
            'user_id'     => session()->get('userId') // "Stempel" dengan ID user
        ];

        $transaksiModel->save($data);

        session()->setFlashdata('pesan', 'Data transaksi berhasil ditambahkan.');
        return redirect()->to('/transaksi');
    }

    public function edit($id)
    {
        $transaksiModel = new TransaksiModel();
        $kategoriModel = new KategoriModel();
        $userId = session()->get('userId');

        $data['transaksi'] = $transaksiModel->find($id);

        // --- PERUBAHAN DI SINI ---
        // Keamanan: Pastikan data ini milik user yang login
        if (empty($data['transaksi']) || $data['transaksi']['user_id'] != $userId) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa mengedit data ini.']);
            return redirect()->to('/transaksi');
        }

        // Ambil hanya kategori milik user untuk dropdown
        $data['kategori'] = $kategoriModel->where('user_id', $userId)->findAll();

        return view('transaksi/edit', $data);
    }

    public function update()
    {
        // ... (aturan validasi Anda sudah benar) ...
        $rules = [ /* ... */ ];
        if (! $this->validate($rules)) {
            // ...
        }
        
        $transaksiModel = new TransaksiModel();
        $id = $this->request->getPost('id');
        $userId = session()->get('userId');

        // --- PERUBAHAN DI SINI ---
        // Keamanan: Cek kepemilikan data sebelum update
        $transaksiLama = $transaksiModel->find($id);
        if (empty($transaksiLama) || $transaksiLama['user_id'] != $userId) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa mengubah data ini.']);
            return redirect()->to('/transaksi');
        }

        $data = [
            'tanggal'     => $this->request->getPost('tanggal'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'tipe'        => $this->request->getPost('tipe'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'keterangan'  => $this->request->getPost('keterangan')
        ];

        $transaksiModel->update($id, $data);

        session()->setFlashdata('pesan', 'Data transaksi berhasil diubah.');
        return redirect()->to('/transaksi');
    }

    public function delete($id)
    {
        $transaksiModel = new TransaksiModel();
        $userId = session()->get('userId');

        // --- PERUBAHAN DI SINI ---
        // Keamanan: Cek kepemilikan data sebelum dihapus
        $transaksi = $transaksiModel->find($id);
        if (empty($transaksi) || $transaksi['user_id'] != $userId) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa menghapus data ini.']);
            return redirect()->to('/transaksi');
        }

        $transaksiModel->delete($id);

        session()->setFlashdata('pesan', 'Data transaksi berhasil dihapus.');
        return redirect()->to('/transaksi');
    }
}