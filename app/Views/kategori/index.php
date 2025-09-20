<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col">
        <h3 class="fw-bold">Manajemen Kategori</h3>
        <p class="text-muted">Tambah, edit, atau hapus kategori pemasukan dan pengeluaran.</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <strong>Tambah Kategori Baru</strong>
    </div>
    <div class="card-body">
        <form action="/kategori/store" method="post">
            <div class="input-group">
                <select id="nama_kategori_select" name="nama_kategori_select" class="form-select" style="width: 35%;">
                    <option value="">-- Pilih Kategori yang Disarankan --</option>
                    <optgroup label="Pemasukan">
                        <?php foreach($saran_kategori['Pemasukan'] as $saran): ?>
                            <option value="<?= $saran ?>"><?= $saran ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Pengeluaran">
                        <?php foreach($saran_kategori['Pengeluaran'] as $saran): ?>
                            <option value="<?= $saran ?>"><?= $saran ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <option value="lainnya">Lainnya...</option>
                </select>
                <input type="text" id="nama_kategori_custom" name="nama_kategori_custom" class="form-control" placeholder="Masukkan Nama Kategori Baru" style="display:none;">
                <input type="number" name="anggaran" class="form-control" placeholder="Anggaran (Rp)">
                <select name="tipe" class="form-select" required>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Daftar Kategori Tersimpan</strong>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Tipe</th>
                    <th>Anggaran (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $item): ?>
                <tr>
                    <td><?= esc($item['nama_kategori']) ?></td>
                    <td><?= esc($item['tipe']) ?></td>
                    <td>
                        <?php if($item['tipe'] == 'pengeluaran' && $item['anggaran'] > 0): ?>
                            <?= number_format($item['anggaran'], 0, ',', '.') ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/kategori/edit/<?= $item['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/kategori/delete/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Script Anda untuk menampilkan input custom 'Lainnya...'
</script>

<?= $this->endSection() ?>