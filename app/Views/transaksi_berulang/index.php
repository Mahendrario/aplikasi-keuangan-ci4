<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header"><strong>Tambah Aturan Baru</strong></div>
            <div class="card-body">
                <form action="/transaksi-berulang/store" method="post">
                    <div class="mb-3">
                        <label for="frekuensi" class="form-label">Frekuensi</label>
                        <select name="frekuensi" class="form-select" required>
                            <option value="bulanan">Bulanan</option>
                            <option value="mingguan">Mingguan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hari_eksekusi" class="form-label">Hari/Tanggal Eksekusi</label>
                        <input type="number" name="hari_eksekusi" class="form-control" placeholder="Tgl (1-31) atau Hari (1-7)" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan Aturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><strong>Daftar Aturan Aktif</strong></div>
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                        <?php foreach($aturan as $item): ?>
                        <tr>
                            <td><?= esc($item['keterangan']) ?></td>
                            <td>Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></td>
                            <td>Setiap <?= $item['frekuensi'] == 'bulanan' ? 'tanggal '.$item['hari_eksekusi'] : 'hari ke-'.$item['hari_eksekusi'] ?></td>
                            <td>
                                <a href="/transaksi-berulang/delete/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>