<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KeuanganKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #001f3f, #3d9970); /* Biru Tua ke Hijau Lumut */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan putih */
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 450px; /* Batasi lebar card */
            width: 100%;
            text-align: center;
        }
        .login-card .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .login-card .form-control:focus {
            border-color: #3d9970; /* Warna fokus */
            box-shadow: 0 0 0 0.25rem rgba(61, 153, 112, 0.25);
        }
        .login-card .btn-primary {
            background: linear-gradient(90deg, #007bff, #3d9970); /* Gradasi tombol */
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
            text-align: center;
        }
        .logo-container img {
            max-height: 50px; /* Atur tinggi maksimal logo */
            width: auto;
        }
        .text-muted a {
            color: #007bff; /* Warna link default Bootstrap */
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
        .input-group-text {
            background-color: transparent;
            border-left: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }
        .input-group .form-control {
            border-right: none;
        }
    </style>
</head>
    <body>
        <div class="login-card">
            <a class="navbar-brand" href="/">
                <img src="<?= base_url('img/logo.png') ?>" alt="Logo" style="height: 50px;">
            </a>
            
            <h4 class="mb-2" style="color: #333;"></h4>
            <p class="mb-4 text-muted"></p>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="alamat@email.com" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        <span class="input-group-text" id="togglePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.174-.195.25-.09.09-.19.18-.297.26-.08.065-.165.131-.258.196a13.125 13.125 0 0 1-1.678 2.05A12.71 12.71 0 0 1 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p class="text-muted mb-0">Belum punya akun? <a href="/register">Daftar sekarang</a></p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Script untuk toggle password visibility
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if(togglePassword) { // Pastikan elemen ada
                togglePassword.addEventListener('click', function (e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    // toggle the eye icon
                    this.innerHTML = type === 'password' 
                        ? `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.174-.195.25-.09.09-.19.18-.297.26-.08.065-.165.131-.258.196a13.125 13.125 0 0 1-1.678 2.05A12.71 12.71 0 0 1 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>` 
                        : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.174-.195.25-.09.09-.19.18-.297.26-.08.065-.165.131-.258.196a13.125 13.125 0 0 1-1.678 2.05l.77.772zm-7.315 5.26c-.795-.145-1.428-.949-1.428-.949a1.944 1.944 0 0 1-.225-.352l-.77-.772A12.162 12.162 0 0 0 0 8s3-5.5 8-5.5c.935 0 1.81.168 2.61.472l.77-.772A7.029 7.029 0 0 0 8 2.5c-2.5 0-4.827 1.34-6.248 3.42L1.172 8l1.624 2.165zM5.275 8.169c.356.356.817.551 1.309.551.332 0 .616-.109.843-.284l.77-.771a3.535 3.535 0 0 1-.77-.772A2.5 2.5 0 0 0 8 5.5a2.5 2.5 0 0 0-2.5 2.5c0 .492.195.953.551 1.31l-.77.771z"/>
                            </svg>`;
                });
            }
        </script>
    </body>
</html>