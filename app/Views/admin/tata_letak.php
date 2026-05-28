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

    <style>
        :root {
            --bg: #f4f7fb;
            --bg-soft: #ffffff;
            --bg-muted: #eef3f8;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #dbe4ee;
            --primary: #136f4f;
            --primary-soft: #e6f5ef;
            --primary-hover: #0f5d42;
            --danger: #dc2626;
            --danger-soft: #fee2e2;
            --warning: #b7791f;
            --warning-soft: #fff7db;
            --success: #15803d;
            --success-soft: #dcfce7;
            --shadow: 0 18px 45px rgba(15, 23, 42, .08);
            --shadow-soft: 0 10px 25px rgba(15, 23, 42, .06);
            --sidebar: #ffffff;
            --input: #ffffff;
        }

        [data-admin-theme="dark"] {
            --bg: #0b1120;
            --bg-soft: #111827;
            --bg-muted: #1e293b;
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --border: #273449;
            --primary: #34d399;
            --primary-soft: rgba(52, 211, 153, .12);
            --primary-hover: #10b981;
            --danger: #f87171;
            --danger-soft: rgba(248, 113, 113, .12);
            --warning: #fbbf24;
            --warning-soft: rgba(251, 191, 36, .12);
            --success: #4ade80;
            --success-soft: rgba(74, 222, 128, .12);
            --shadow: 0 18px 45px rgba(0, 0, 0, .28);
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, .20);
            --sidebar: #0f172a;
            --input: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(19, 111, 79, .12), transparent 32rem),
                var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
            min-height: 100vh;
        }

        .admin-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 24px 18px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            overflow-y: auto;
            z-index: 10;
        }

        .brand-box {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 14px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: #ffffff;
            box-shadow: 0 18px 30px rgba(19, 111, 79, .22);
            margin-bottom: 22px;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .18);
            font-weight: 900;
            letter-spacing: .5px;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 900;
            line-height: 1.2;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 12px;
            margin: 4px 0 0;
            opacity: .82;
        }

        .admin-user {
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--bg-soft);
            margin-bottom: 18px;
        }

        .admin-user strong {
            display: block;
            font-size: 14px;
        }

        .admin-user span {
            display: block;
            margin-top: 4px;
            color: var(--text-muted);
            font-size: 12px;
        }

        .nav-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin: 18px 12px 8px;
        }

        .admin-nav {
            display: grid;
            gap: 6px;
        }

        .admin-nav a,
        .theme-button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            border: 0;
            cursor: pointer;
            padding: 11px 12px;
            border-radius: 14px;
            color: var(--text-muted);
            background: transparent;
            font-weight: 750;
            font-size: 14px;
            transition: .18s ease;
            text-align: left;
        }

        .admin-nav a:hover,
        .theme-button:hover,
        .admin-nav a.active {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .nav-icon {
            width: 28px;
            height: 28px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            background: var(--bg-muted);
            color: var(--primary);
            flex: 0 0 auto;
        }

        .admin-main {
            min-width: 0;
            padding: 26px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-size: clamp(24px, 3vw, 36px);
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .page-subtitle {
            margin: 8px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .content-card {
            background: rgba(255, 255, 255, .74);
            background: color-mix(in srgb, var(--bg-soft) 92%, transparent);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 18px;
            border: 1px solid var(--border);
            margin-bottom: 18px;
            font-weight: 700;
            line-height: 1.55;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-soft);
            border-color: color-mix(in srgb, var(--success) 30%, transparent);
        }

        .alert-error {
            color: var(--danger);
            background: var(--danger-soft);
            border-color: color-mix(in srgb, var(--danger) 30%, transparent);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 16px;
            border-radius: 14px;
            border: 1px solid transparent;
            font-weight: 850;
            font-size: 14px;
            cursor: pointer;
            transition: .18s ease;
            white-space: nowrap;
        }

        .btn-primary {
            color: #ffffff;
            background: var(--primary);
            box-shadow: 0 12px 20px rgba(19, 111, 79, .18);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            color: var(--text);
            background: var(--bg-soft);
            border-color: var(--border);
        }

        .btn-secondary:hover {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .btn-danger {
            color: var(--danger);
            background: var(--danger-soft);
            border-color: color-mix(in srgb, var(--danger) 25%, transparent);
        }

        .btn-danger:hover {
            color: #ffffff;
            background: var(--danger);
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 22px;
        }

        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            background: var(--bg-soft);
        }

        .admin-table th {
            text-align: left;
            padding: 14px 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            background: var(--bg-muted);
            border-bottom: 1px solid var(--border);
        }

        .admin-table td {
            padding: 15px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
            color: var(--text);
        }

        .admin-table tr:last-child td {
            border-bottom: 0;
        }

        .admin-table tr:hover td {
            background: color-mix(in srgb, var(--primary-soft) 48%, transparent);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .badge-active {
            color: var(--success);
            background: var(--success-soft);
        }

        .badge-inactive {
            color: var(--warning);
            background: var(--warning-soft);
        }

        .empty-state {
            text-align: center;
            padding: 42px 20px;
            border: 1px dashed var(--border);
            border-radius: 24px;
            background: var(--bg-soft);
        }

        .empty-state h3 {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .empty-state p {
            margin: 0;
            color: var(--text-muted);
        }

        .admin-form {
            display: grid;
            gap: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 850;
            color: var(--text);
        }

        .form-help {
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .form-control {
            width: 100%;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid var(--border);
            border-radius: 16px;
            outline: none;
            color: var(--text);
            background: var(--input);
            transition: .18s ease;
        }

        textarea.form-control {
            min-height: 180px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            padding-top: 8px;
        }

        .preview-img {
            width: 130px;
            height: 86px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: var(--bg-muted);
        }

        .image-thumb {
            width: 90px;
            height: 58px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--bg-muted);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .stat-card {
            padding: 20px;
            border-radius: 24px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .stat-card span {
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 800;
        }

        .stat-card strong {
            display: block;
            margin-top: 10px;
            font-size: 30px;
            letter-spacing: -.04em;
        }

        .page-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .page-card {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 20px;
            border-radius: 24px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            box-shadow: var(--shadow-soft);
            transition: .18s ease;
        }

        .page-card:hover {
            transform: translateY(-3px);
            border-color: color-mix(in srgb, var(--primary) 40%, var(--border));
        }

        .page-card h3 {
            margin: 0;
            font-size: 18px;
        }

        .page-card p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.55;
        }

        @media (max-width: 1100px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .admin-sidebar {
                position: relative;
                height: auto;
            }

            .admin-nav {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .stat-grid,
            .page-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .admin-main {
                padding: 18px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar-actions {
                width: 100%;
                justify-content: stretch;
            }

            .topbar-actions .btn,
            .theme-button {
                width: 100%;
            }

            .admin-nav,
            .stat-grid,
            .page-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .content-card {
                padding: 18px;
                border-radius: 22px;
            }
        }
    </style>
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
    </script>
</body>
</html>