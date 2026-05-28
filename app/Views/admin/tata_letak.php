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
                    <span>Dashboard</span>
                </a>

                <a href="<?= site_url('admin/halaman/beranda') ?>" class="<?= adminAktif('halaman/beranda', $uriString) ?>">
                    <span class="nav-icon">H</span>
                    <span>Beranda</span>
                </a>

                <a href="<?= site_url('admin/halaman/profile') ?>" class="<?= adminAktif('halaman/profile', $uriString) ?>">
                    <span class="nav-icon">P</span>
                    <span>Profile</span>
                </a>

                <a href="<?= site_url('admin/halaman/tenaga-pengajar') ?>" class="<?= adminAktif('tenaga-pengajar', $uriString) ?>">
                    <span class="nav-icon">G</span>
                    <span>Tenaga Pengajar</span>
                </a>

                <a href="<?= site_url('admin/halaman/unit-kb-tk') ?>" class="<?= adminAktif('unit-kb-tk', $uriString) ?>">
                    <span class="nav-icon">K</span>
                    <span>Unit KB/TK</span>
                </a>

                <a href="<?= site_url('admin/halaman/unit-tpq') ?>" class="<?= adminAktif('unit-tpq', $uriString) ?>">
                    <span class="nav-icon">T</span>
                    <span>Unit TPQ</span>
                </a>

                <a href="<?= site_url('admin/halaman/unit-dc') ?>" class="<?= adminAktif('unit-dc', $uriString) ?>">
                    <span class="nav-icon">D</span>
                    <span>Unit Daycare</span>
                </a>

                <a href="<?= site_url('admin/halaman/unit-lansia') ?>" class="<?= adminAktif('unit-lansia', $uriString) ?>">
                    <span class="nav-icon">L</span>
                    <span>Unit Lansia</span>
                </a>

                <a href="<?= site_url('admin/halaman/informasi') ?>" class="<?= adminAktif('halaman/informasi', $uriString) ?>">
                    <span class="nav-icon">I</span>
                    <span>Informasi</span>
                </a>
            </nav>

            <div class="nav-label">Website</div>

            <nav class="admin-nav">
                <a href="<?= site_url('home/beranda') ?>" target="_blank">
                    <span class="nav-icon">↗</span>
                    <span>Lihat Website</span>
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
                    <button type="button" class="btn btn-secondary" id="themeToggle">
                        <span id="themeIcon">☀</span>
                        <span id="themeText">Tema Terang</span>
                    </button>

                    <div class="admin-profile-wrapper">
                        <button type="button" class="admin-profile-button" id="adminProfileButton" aria-label="Menu admin">
                            <img
                                src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                                alt="Admin"
                                class="admin-profile-img"
                            >
                        </button>

                        <div class="admin-profile-dropdown" id="adminProfileDropdown">
                            <div class="admin-profile-info">
                                <img
                                    src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                                    alt="Admin"
                                    class="admin-profile-dropdown-img"
                                >

                                <div>
                                    <strong><?= esc($namaAdmin) ?></strong>
                                    <span>@<?= esc($usernameAdmin) ?></span>
                                </div>
                            </div>

                            <div class="admin-profile-menu">
                                <a href="<?= site_url('admin/ubah-password') ?>">
                                    Ubah Password
                                </a>

                                <a href="<?= site_url('admin/logout') ?>" class="danger">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
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

        const adminProfileButton = document.getElementById('adminProfileButton');
        const adminProfileDropdown = document.getElementById('adminProfileDropdown');

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

        adminProfileButton.addEventListener('click', function (event) {
            event.stopPropagation();
            adminProfileDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!adminProfileDropdown.contains(event.target) && !adminProfileButton.contains(event.target)) {
                adminProfileDropdown.classList.remove('show');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                adminProfileDropdown.classList.remove('show');
            }
        });

        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                const inputId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(inputId);

                if (!input) {
                    return;
                }

                const sedangPassword = input.getAttribute('type') === 'password';

                input.setAttribute('type', sedangPassword ? 'text' : 'password');
                button.textContent = sedangPassword ? 'Tutup' : 'Lihat';
                button.setAttribute(
                    'aria-label',
                    sedangPassword ? 'Sembunyikan password' : 'Tampilkan password'
                );
            });
        });
    </script>
</body>
</html>