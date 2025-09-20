<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 class="fw-bold">Dashboard Keuangan</h3>
        <p class="text-muted">Ringkasan aktivitas keuangan Anda.</p>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-md-end align-items-center">
            <form action="/" method="post" class="d-flex align-items-center">
                <input type="date" class="form-control me-2" style="max-width: 170px;" name="start_date" value="<?= $start_date ?? '' ?>">
                <span class="me-2">-</span>
                <input type="date" class="form-control me-2" style="max-width: 170px;" name="end_date" value="<?= $end_date ?? '' ?>">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            
            <a href="/transaksi-berulang/execute" class="btn btn-success ms-2">Jalankan Rutin</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card summary-card card-pemasukan">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Pemasukan</h6>
                <p class="card-text display-6 fw-bold">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card summary-card card-pengeluaran">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Pengeluaran</h6>
                <p class="card-text display-6 fw-bold">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card summary-card card-saldo">
            <div class="card-body">
                <h6 class="card-title text-muted">Saldo Akhir</h6>
                <p class="card-text display-6 fw-bold">Rp <?= number_format($saldo, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Grafik Pengeluaran per Kategori
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="position: relative; min-height: 350px;">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Progress Anggaran Bulan Ini
            </div>
            <div class="card-body">
                <?php if (empty($progress_anggaran)): ?>
                    <p class="text-center text-muted mt-3">Belum ada anggaran yang diatur.</p>
                <?php else: ?>
                    <?php foreach($progress_anggaran as $anggaran): ?>
                        <?php
                            $pengeluaran = $anggaran['total_pengeluaran'] ?? 0;
                            $budget = $anggaran['anggaran'];
                            $persentase = ($budget > 0) ? ($pengeluaran / $budget) * 100 : 0;
                            
                            $warna_progress = 'bg-success';
                            if ($persentase > 75) $warna_progress = 'bg-warning';
                            if ($persentase >= 100) $warna_progress = 'bg-danger';
                            if ($persentase > 100) $persentase_tampil = 100; else $persentase_tampil = $persentase;
                        ?>
                        <div class="mb-3">
                            <strong><?= esc($anggaran['nama_kategori']) ?></strong>
                            <div class="d-flex justify-content-between text-muted small">
                                <span>Rp <?= number_format($pengeluaran, 0, ',', '.') ?></span>
                                <span>Rp <?= number_format($budget, 0, ',', '.') ?></span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar <?= $warna_progress ?>" role="progressbar" style="width: <?= $persentase_tampil ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="alert alert-light border-0" role="alert">
            <strong class="text-primary">Saran untuk Anda:</strong> <?= $saran_finansial ?>
        </div>
    </div>
</div>

<script>
    // Pastikan elemen canvas ada
    const canvasElement = document.getElementById('myPieChart');
    if (canvasElement) {
        const chartData = <?= json_encode($chart_data) ?>;
        const labels = chartData.map(item => item.nama_kategori);
        const data = chartData.map(item => item.total);
        
        const ctx = canvasElement.getContext('2d');
        const myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengeluaran',
                    data: data,
                    backgroundColor: ['#3498db', '#e74c3c', '#f1c40f', '#2ecc71', '#9b59b6', '#34495e'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }
</script>

<?= $this->endSection() ?>