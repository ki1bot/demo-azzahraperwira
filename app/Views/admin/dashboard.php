<?php
$daftarHalaman = $daftarHalaman ?? [];

$deskripsiHalaman = [
    'beranda'         => 'Kelola konten utama halaman depan website.',
    'profile'         => 'Kelola profil yayasan, visi, misi, dan informasi lembaga.',
    'tenaga-pengajar' => 'Kelola informasi tenaga pengajar.',
    'unit-kb-tk'      => 'Kelola konten unit KB/TK.',
    'unit-tpq'        => 'Kelola konten unit TPQ.',
    'unit-dc'         => 'Kelola konten unit Daycare.',
    'unit-lansia'     => 'Kelola konten unit Lansia.',
    'informasi'       => 'Kelola informasi, kegiatan, dan pengumuman.',
    'footer'          => 'Kelola konten footer website.',
];

$adminHalamanUrl = static function (string $kode): string {
    return base_url('admin/' . trim($kode, '/') . '/index.php');
};
?>

<div class="stat-grid">
    <div class="stat-card">
        <span>Total Halaman</span>
        <strong><?= count($daftarHalaman) ?></strong>
    </div>

    <div class="stat-card">
        <span>Status</span>
        <strong>Admin</strong>
    </div>

    <div class="stat-card">
        <span>Status Login</span>
        <strong>Aktif</strong>
    </div>

    <div class="stat-card">
        <span>Akses</span>
        <strong>Full</strong>
    </div>
</div>

<div class="section-heading">
    <h2>Dashboard Admin</h2>
    <p>Pilih halaman yang ingin dikelola. Setiap halaman bisa dikelola melalui URL admin khusus.</p>
</div>

<?php if (! empty($daftarHalaman)): ?>
    <div class="page-grid">
        <?php foreach ($daftarHalaman as $kode => $nama): ?>
            <article class="page-card">
                <div>
                    <span class="badge badge-active">Halaman</span>
                </div>

                <div>
                    <h3><?= esc($nama) ?></h3>
                    <p><?= esc($deskripsiHalaman[$kode] ?? 'Kelola konten halaman website.') ?></p>
                </div>

                <div class="card-action">
                    <a href="<?= $adminHalamanUrl($kode) ?>" class="btn btn-primary">
                        Kelola Konten
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <h3>Belum ada halaman tersedia</h3>
        <p>Daftar halaman belum ditemukan dari model konten.</p>
    </div>
<?php endif; ?>