    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelola Keuangan Pribadi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            /* Hapus padding-top agar konten tidak terlalu jauh ke bawah */
        }
        .navbar-brand {
            font-weight: bold;
        }
        .custom-navbar {
            /* Ganti shadow mengambang dengan shadow garis bawah tipis */
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Efek hover ini bisa tetap Anda gunakan jika suka */
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #000;
            background-color: #f1f5f9;
            border-radius: 5px;
        }
        
        /* Tombol bisa kita gunakan style default bootstrap saja */
        .btn-custom-solid {
            background-color: #0d6efd; /* Biru */
            color: white;
        }
        .btn-custom-outline {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        .btn-custom-outline:hover {
            background-color: #0d6efd;
            color: white;
        }
        /* (di dalam file layout/template.php) */
        /* ... (style Anda yang sudah ada) ... */

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .summary-card {
            border-radius: 15px;
            color: #fff;
        }
        .summary-card .card-title {
            color: rgba(255,255,255,0.8);
        }
        .card-pemasukan { background-color: #28a745; }
        .card-pengeluaran { background-color: #dc3545; }
        .card-saldo { background-color: #17a2b8; }
        .progress { border-radius: 5px; }

    </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-white custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="<?= base_url('img/logo.png') ?>" alt="Logo" style="height: 35px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                        <a class="nav-link" href="/">Dashboard</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/kategori">Kategori</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/transaksi">Transaksi</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/laporan">Laporan</a>
                        </li>
                    <?php endif; ?>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item d-none d-lg-block">
                            <div class="vr mx-2"></div>
                        </li>
                    <?php endif; ?>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?= session()->get('userName') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                        </li>
                        <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm" href="/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        
        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>