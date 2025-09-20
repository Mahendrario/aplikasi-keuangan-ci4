<?php

namespace App\Controllers;

use App\Models\KategoriModel; // Jangan lupa panggil Model-nya

class Kategori extends BaseController
{
    public function index()
    {
        $kategoriModel = new \App\Models\KategoriModel();
        
        // Daftar saran kategori (logika ini tetap sama)
        $saran_kategori = [
            'Pemasukan' => ['Gaji', 'Bonus', 'Usaha Sampingan', 'Hadiah'],
            'Pengeluaran' => [
                'Belanja Bulanan', 'Tagihan', 'Transportasi', 'Cicilan / Hutang',
                'Makan di Luar / Jajan', 'Hiburan', 'Hobi', 'Belanja Pakaian',
                'Liburan', 'Kesehatan', 'Pendidikan', 'Donasi / Sosial'
            ]
        ];

        // --- PERUBAHAN DI SINI ---
        // Ambil hanya kategori milik user yang sedang login
        $data['kategori'] = $kategoriModel->where('user_id', session()->get('userId'))->findAll();
        
        $data['saran_kategori'] = $saran_kategori;

        return view('kategori/index', $data);
    }

    public function store()
    {
        // Ambil data dari form terlebih dahulu
        $pilihan_kategori = $this->request->getPost('nama_kategori_select');
        $kategori_custom = $this->request->getPost('nama_kategori_custom');

        // Tentukan nama kategori final berdasarkan pilihan user
        $nama_kategori_final = ($pilihan_kategori === 'lainnya') ? $kategori_custom : $pilihan_kategori;

        // --- VALIDASI BARU YANG LEBIH SEDERHANA ---
        $rules = [
            'nama_kategori_final' => [
                'label'  => 'Nama Kategori', // Nama yang lebih ramah untuk pesan error
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => '{field} harus dipilih atau diisi.',
                    'min_length' => '{field} minimal 3 karakter.'
                ]
            ],
            'tipe' => [
                'label' => 'Tipe Kategori',
                'rules' => 'required',
                'errors' => ['required' => '{field} harus dipilih.']
            ]
        ];
        
        // Data dummy untuk divalidasi
        $dataToValidate = [
            'nama_kategori_final' => $nama_kategori_final,
            'tipe'                => $this->request->getPost('tipe')
        ];

        if (! $this->validateData($dataToValidate, $rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
        
        // --- AKHIR VALIDASI ---

        // Jika validasi berhasil, simpan data
        $kategoriModel = new \App\Models\KategoriModel();
        $data = [
            'nama_kategori' => $nama_kategori_final,
            'tipe'          => $this->request->getPost('tipe'),
            'anggaran'      => $this->request->getPost('anggaran') ?: 0,
            'user_id'       => session()->get('userId')
        ];

        $kategoriModel->save($data);

        session()->setFlashdata('pesan', 'Data kategori berhasil ditambahkan.');
        return redirect()->to('/kategori');
    }
    public function edit($id)
    {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->find($id);

        // --- PERUBAHAN DI SINI ---
        // Pengecekan keamanan: Pastikan data ini milik user yang login
        if (empty($data['kategori']) || $data['kategori']['user_id'] != session()->get('userId')) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa mengedit data ini.']);
            return redirect()->to('/kategori');
        }

        return view('kategori/edit', $data);
    }

    public function update()
    {
        $kategoriModel = new \App\Models\KategoriModel();
        $id = $this->request->getPost('id');

        // --- PERUBAHAN DI SINI ---
        // Pengecekan keamanan: Pastikan data yang akan diupdate adalah milik user
        $kategoriLama = $kategoriModel->find($id);
        if (empty($kategoriLama) || $kategoriLama['user_id'] != session()->get('userId')) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa mengubah data ini.']);
            return redirect()->to('/kategori');
        }

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'tipe'          => $this->request->getPost('tipe'),
            'anggaran'      => $this->request->getPost('anggaran') ?: 0 
        ];

        $kategoriModel->update($id, $data);

        session()->setFlashdata('pesan', 'Data kategori berhasil diubah.');
        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $kategoriModel = new KategoriModel();

        // --- PERUBAHAN DI SINI ---
        // Pengecekan keamanan: Pastikan data yang akan dihapus adalah milik user
        $kategori = $kategoriModel->find($id);
        if (empty($kategori) || $kategori['user_id'] != session()->get('userId')) {
            session()->setFlashdata('errors', ['Akses ditolak. Anda tidak bisa menghapus data ini.']);
            return redirect()->to('/kategori');
        }

        $kategoriModel->delete($id);

        session()->setFlashdata('pesan', 'Data kategori berhasil dihapus.');
        return redirect()->to('/kategori');
    }
}