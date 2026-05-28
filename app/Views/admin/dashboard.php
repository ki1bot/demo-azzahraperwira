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
];
?>

<div class="stat-grid">
    <div class="stat-card">
        <span>Total Halaman</span>
        <strong><?= count($daftarHalaman) ?></strong>
    </div>

    <div class="stat-card">
        <span>Mode Admin</span>
        <strong>CMS</strong>
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

<div style="margin-bottom: 22px;">
    <h2 style="margin: 0 0 8px; font-size: 24px;">Dashboard Admin</h2>
    <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">
        Pilih halaman yang ingin dikelola. Setiap halaman bisa ditambah, diedit, dan dihapus konten teks atau gambarnya.
    </p>
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

                <div style="margin-top: auto;">
                    <a href="<?= site_url('admin/halaman/' . $kode) ?>" class="btn btn-primary">
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