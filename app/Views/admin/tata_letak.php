<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>
        <?= esc($judul ?? 'Admin') ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .pembungkus {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #111827;
            color: #ffffff;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            font-size: 20px;
            margin: 0 0 24px;
        }

        .sidebar a {
            display: block;
            color: #e5e7eb;
            text-decoration: none;
            padding: 10px 0;
        }

        .sidebar a:hover {
            color: #ffffff;
        }

        .konten {
            flex: 1;
            padding: 28px;
            box-sizing: border-box;
        }

        .bar-atas {
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kartu {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        .tombol {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-size: 14px;
        }

        .tombol-utama {
            background: #1f2937;
            color: #ffffff;
        }

        .tombol-peringatan {
            background: #f59e0b;
            color: #111827;
        }

        .tombol-bahaya {
            background: #dc2626;
            color: #ffffff;
        }

        .tombol-kedua {
            background: #e5e7eb;
            color: #111827;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 160px;
        }

        .grup-form {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        img.pratinjau {
            max-width: 160px;
            border-radius: 8px;
        }

        .teks-kecil {
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="pembungkus">
        <aside class="sidebar">
            <h2>Halaman Admin</h2>

            <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
            <a href="<?= site_url('admin/halaman/beranda') ?>">Beranda</a>
            <a href="<?= site_url('admin/halaman/profile') ?>">Profile</a>
            <a href="<?= site_url('admin/halaman/tenaga-pengajar') ?>">Tenaga Pengajar</a>
            <a href="<?= site_url('admin/halaman/unit-kb-tk') ?>">Unit KB/TK</a>
            <a href="<?= site_url('admin/halaman/unit-tpq') ?>">Unit TPQ</a>
            <a href="<?= site_url('admin/halaman/unit-dc') ?>">Unit Daycare</a>
            <a href="<?= site_url('admin/halaman/unit-lansia') ?>">Unit Lansia</a>
            <a href="<?= site_url('admin/halaman/informasi') ?>">Informasi</a>
            <a href="<?= site_url('/') ?>" target="_blank">Lihat Website</a>
            <a href="<?= site_url('admin/logout') ?>">Logout</a>
        </aside>

        <main class="konten">
            <div class="bar-atas">
                <strong>
                    <?= esc($judul ?? 'Admin') ?>
                </strong>
                <span>
                    <?= esc(session()->get('nama_admin') ?? 'Admin') ?>
                </span>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>
            <?= $isi_admin ?? '' ?>
        </main>
    </div>
</body>

</html>