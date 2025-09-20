<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KeuanganKu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #001f3f, #3d9970); /* Biru Tua ke Hijau Lumut */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0; /* Tambahkan padding untuk layar kecil */
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        .login-card .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .login-card .form-control:focus {
            border-color: #3d9970;
            box-shadow: 0 0 0 0.25rem rgba(61, 153, 112, 0.25);
        }
        .login-card .btn-primary {
            background: linear-gradient(90deg, #007bff, #3d9970);
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .login-card .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .logo-container {
            margin-bottom: 30px;
        }
        .logo-container img {
            max-height: 50px;
            width: auto;
        }
        .text-muted a {
            color: #007bff;
            text-decoration: none;
        }
        .text-muted a:hover {
            text-decoration: underline;
        }
        .form-label {
            text-align: left;
            width: 100%;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-card">

        <h4 class="mb-2" style="color: #333;">Buat Akun Baru</h4>
        <p class="mb-4 text-muted">Isi data diri Anda untuk memulai.</p>

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>

        <form action="/register" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="alamat@email.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="mb-4">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ketik ulang password" required>
            </div>
            <div class="d-grid gap-2 mb-4">
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
        </form>
        <p class="text-muted mb-0">Sudah punya akun? <a href="/login">Login di sini</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>