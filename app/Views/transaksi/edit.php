<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Edit Transaksi</h2>
    </div>
    
    <div class="card-body">
        <form action="/transaksi/update" method="post">
            <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" value="<?= $transaksi['tanggal'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                <input type="number" class="form-control" name="jumlah" value="<?= $transaksi['jumlah'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe Transaksi</label>
                <select name="tipe" class="form-select" required>
                    <option value="pemasukan" <?= ($transaksi['tipe'] == 'pemasukan') ? 'selected' : '' ?>>Pemasukan</option>
                    <option value="pengeluaran" <?= ($transaksi['tipe'] == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select name="id_kategori" class="form-select" required>
                    <?php foreach ($kategori as $item): ?>
                        <option value="<?= $item['id'] ?>" <?= ($item['id'] == $transaksi['id_kategori']) ? 'selected' : '' ?>>
                            <?= esc($item['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="3"><?= $transaksi['keterangan'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Transaksi</button>
            <a href="/transaksi" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>