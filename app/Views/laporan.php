<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col">
        <h3 class="fw-bold">Laporan Keuangan</h3>
        <p class="text-muted">Lihat ringkasan keuangan berdasarkan periode yang Anda pilih.</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <strong>Pilih Periode Laporan</strong>
    </div>
    <div class="card-body">
        <form action="/laporan" method="post">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($bulan_terpilih) && $bulan_terpilih == $i) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                            <option value="<?= $i ?>" <?= (isset($tahun_terpilih) && $tahun_terpilih == $i) ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset($ringkasan)): ?>
<div class="card">
    <div class="card-header">
        <strong>Hasil Laporan untuk <?= date('F Y', mktime(0, 0, 0, $bulan_terpilih, 1, $tahun_terpilih)) ?></strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card summary-card card-pemasukan mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Pemasukan</h6>
                        <p class="card-text display-6 fw-bold">Rp <?= number_format($ringkasan['pemasukan'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="card summary-card card-pengeluaran mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Pengeluaran</h6>
                        <p class="card-text display-6 fw-bold">Rp <?= number_format($ringkasan['pengeluaran'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card summary-card card-saldo mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Saldo</h6>
                        <p class="card-text display-6 fw-bold">Rp <?= number_format($ringkasan['pemasukan'] - $ringkasan['pengeluaran'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>