<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col">
        <h3 class="fw-bold">Manajemen Transaksi</h3>
        <p class="text-muted">Catat semua pemasukan dan pengeluaran Anda di sini.</p>
    </div>
</div>

<div class="row">

    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <strong>Tambah Transaksi Baru</strong>
            </div>
            <div class="card-body">
                <form action="/transaksi/store" method="post">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Contoh: 50000" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Transaksi</label>
                        <select name="tipe" class="form-select" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $item): ?>
                                <option value="<?= $item['id'] ?>"><?= esc($item['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Riwayat Transaksi</strong>
                <form action="/transaksi" method="get" class="d-flex">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari keterangan..." name="keyword" value="<?= $keyword ?? '' ?>">
                    <button class="btn btn-sm btn-outline-secondary ms-2" type="submit">Cari</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi as $item): ?>
                            <tr>
                                <td><?= esc(date('d M Y', strtotime($item['tanggal']))) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td>
                                    <?php 
                                        $nama_kategori = '...';
                                        foreach($kategori as $kat) {
                                            if($kat['id'] == $item['id_kategori']) {
                                                $nama_kategori = $kat['nama_kategori'];
                                                break;
                                            }
                                        }
                                        echo esc($nama_kategori);
                                    ?>
                                </td>
                                <td class="<?= $item['tipe'] == 'pemasukan' ? 'text-success' : 'text-danger' ?>">
                                    <?= ($item['tipe'] == 'pemasukan' ? '+' : '-') ?> Rp <?= number_format($item['jumlah'], 0, ',', '.') ?>
                                </td>
                                <td>
                                    <a href="/transaksi/edit/<?= $item['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/transaksi/delete/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>