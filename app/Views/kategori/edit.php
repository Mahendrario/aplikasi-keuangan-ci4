<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Kategori</h2>
                </div>
                <div class="card-body">
                    <form action="/kategori/update" method="post">
                        <input type="hidden" name="id" value="<?= $kategori['id'] ?>">

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" value="<?= esc($kategori['nama_kategori']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="anggaran" class="form-label">Anggaran (Rp)</label>
                            <input type="number" class="form-control" name="anggaran" value="<?= esc($kategori['anggaran']) ?>" placeholder="Hanya isi untuk tipe pengeluaran">
                        </div>

                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select name="tipe" class="form-select" required>
                                <option value="pemasukan" <?= ($kategori['tipe'] == 'pemasukan') ? 'selected' : '' ?>>Pemasukan</option>
                                <option value="pengeluaran" <?= ($kategori['tipe'] == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Kategori</button>
                        <a href="/kategori" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>