<?php

namespace App\Controllers; // <-- PERBAIKAN KRITIS DI SINI

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Menampilkan halaman login
    public function login()
    {
        return view('login');
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        return view('register');
    }

    // Memproses data dari form registrasi
    public function saveRegister()
    {
        $rules = [
            'nama'             => 'required|min_length[3]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'matches[password]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        $userModel->save($data);

        session()->setFlashdata('pesan', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }

    // Memproses data dari form login
    public function attemptLogin()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        // Cek jika user ada DAN password cocok
        if ($user && password_verify($password, $user['password_hash'])) {
            // Buat session
            session()->set([
                'isLoggedIn' => true,
                'userId'     => $user['id'],
                'userName'   => $user['nama']
            ]);
            
            return redirect()->to('/'); // Arahkan ke dashboard
        }

        // Jika login gagal
        session()->setFlashdata('errors', ['Email atau password salah.']);
        return redirect()->to('/login')->withInput();
    }

    // Proses logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}