<?php
$judulHalaman = $judul ?? 'Admin';
$namaAdmin = session()->get('nama_admin') ?? 'Admin';
$usernameAdmin = session()->get('username_admin') ?? 'admin';
$uriString = uri_string();

function adminAktif(string $kataKunci, string $uriString): string
{
    return str_contains($uriString, $kataKunci) ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="id" data-admin-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judulHalaman) ?> - Admin Yayasan</title>

    <script>
        (function () {
            const tema = localStorage.getItem('tema-admin-yayasan') || 'light';
            document.documentElement.setAttribute('data-admin-theme', tema);
        })();
    </script>

    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="brand-box">
                <div class="brand-logo">AZ</div>
                <div>
                    <p class="brand-title">Admin Yayasan</p>
                    <p class="brand-subtitle">Az-Zahra Perwira</p>
                </div>
            </div>

            <div class="admin-user">
                <strong><?= esc($namaAdmin) ?></strong>
                <span>@<?= esc($usernameAdmin) ?></span>
            </div>

            <div class="nav-label">Menu Utama</div>

            <nav class="admin-nav">
                <a href="<?= site_url('admin/dashboard') ?>" class="<?= adminAktif('admin/dashboard', $uriString) ?>">
                    <span class="nav-icon">⌂</span>
                    Dashboard
                </a>

                <a href="<?= site_url('admin/halaman/beranda') ?>" class="<?= adminAktif('halaman/beranda', $uriString) ?>">
                    <span class="nav-icon">H</span>
                    Beranda
                </a>

                <a href="<?= site_url('admin/halaman/profile') ?>" class="<?= adminAktif('halaman/profile', $uriString) ?>">
                    <span class="nav-icon">P</span>
                    Profile
                </a>

                <a href="<?= site_url('admin/halaman/tenaga-pengajar') ?>" class="<?= adminAktif('tenaga-pengajar', $uriString) ?>">
                    <span class="nav-icon">G</span>
                    Tenaga Pengajar
                </a>

                <a href="<?= site_url('admin/halaman/unit-kb-tk') ?>" class="<?= adminAktif('unit-kb-tk', $uriString) ?>">
                    <span class="nav-icon">K</span>
                    Unit KB/TK
                </a>

                <a href="<?= site_url('admin/halaman/unit-tpq') ?>" class="<?= adminAktif('unit-tpq', $uriString) ?>">
                    <span class="nav-icon">T</span>
                    Unit TPQ
                </a>

                <a href="<?= site_url('admin/halaman/unit-dc') ?>" class="<?= adminAktif('unit-dc', $uriString) ?>">
                    <span class="nav-icon">D</span>
                    Unit Daycare
                </a>

                <a href="<?= site_url('admin/halaman/unit-lansia') ?>" class="<?= adminAktif('unit-lansia', $uriString) ?>">
                    <span class="nav-icon">L</span>
                    Unit Lansia
                </a>

                <a href="<?= site_url('admin/halaman/informasi') ?>" class="<?= adminAktif('halaman/informasi', $uriString) ?>">
                    <span class="nav-icon">I</span>
                    Informasi
                </a>
            </nav>

            <div class="nav-label">Akun</div>

            <nav class="admin-nav">
                <a href="<?= site_url('admin/ubah-password') ?>" class="<?= adminAktif('ubah-password', $uriString) ?>">
                    <span class="nav-icon">●</span>
                    Ubah Password
                </a>

                <button type="button" class="theme-button" id="themeToggle">
                    <span class="nav-icon" id="themeIcon">☀</span>
                    <span id="themeText">Tema Terang</span>
                </button>

                <a href="<?= site_url('home/beranda') ?>" target="_blank">
                    <span class="nav-icon">↗</span>
                    Lihat Website
                </a>

                <a href="<?= site_url('admin/logout') ?>">
                    <span class="nav-icon">×</span>
                    Logout
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="topbar">
                <div>
                    <h1 class="page-title"><?= esc($judulHalaman) ?></h1>
                    <p class="page-subtitle">Kelola konten website yayasan dari satu panel admin.</p>
                </div>

                <div class="topbar-actions">
                    <a href="<?= site_url('home/beranda') ?>" target="_blank" class="btn btn-secondary">Lihat Website</a>
                    <a href="<?= site_url('admin/ubah-password') ?>" class="btn btn-primary">Ubah Password</a>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <section class="content-card">
                <?= $isi_admin ?? '' ?>
            </section>
        </main>
    </div>

    <script>
        const html = document.documentElement;
        const tombolTema = document.getElementById('themeToggle');
        const teksTema = document.getElementById('themeText');
        const ikonTema = document.getElementById('themeIcon');

        function setTemaAdmin(tema) {
            html.setAttribute('data-admin-theme', tema);
            localStorage.setItem('tema-admin-yayasan', tema);

            if (tema === 'dark') {
                teksTema.textContent = 'Tema Gelap';
                ikonTema.textContent = '☾';
            } else {
                teksTema.textContent = 'Tema Terang';
                ikonTema.textContent = '☀';
            }
        }

        setTemaAdmin(localStorage.getItem('tema-admin-yayasan') || 'light');

        tombolTema.addEventListener('click', function () {
            const temaAktif = html.getAttribute('data-admin-theme') === 'dark' ? 'light' : 'dark';
            setTemaAdmin(temaAktif);
        });

        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                const inputId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(inputId);

                if (! input) {
                    return;
                }

                const sedangPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', sedangPassword ? 'text' : 'password');
                button.textContent = sedangPassword ? 'Tutup' : 'Lihat';
                button.setAttribute('aria-label', sedangPassword ? 'Sembunyikan password' : 'Tampilkan password');
            });
        });
    </script>
</body>
</html>