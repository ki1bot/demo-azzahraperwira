<!DOCTYPE html>
<html lang="id" data-admin-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul ?? 'Login Admin') ?></title>

    <script src="<?= base_url('js/admin.js') ?>"></script>

    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>

<body class="login-body" style="--login-bg-image: url('<?= base_url('assets/img/home/home.jpg') ?>');">
    <button type="button" class="theme-toggle" id="themeToggle">
        Tema
    </button>

    <main class="login-shell">
        <section class="login-hero">
            <div class="login-brand">
                <div class="login-logo">AZ</div>

                <div>
                    <h1>Az-Zahra Perwira</h1>
                    <p>Panel Backend Admin</p>
                </div>
            </div>

            <div class="login-copy">
                <h2>Kelola konten website dengan aman.</h2>
                <p>Masuk sebagai admin untuk mengelola teks, gambar, status konten, dan halaman website yayasan.</p>
            </div>
        </section>

        <section class="login-panel">
            <div class="panel-header">
                <h2>Login Admin</h2>
                <p>Gunakan username dan password admin yang sudah terdaftar.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/login') ?>" method="post" class="form" autocomplete="off">
                <div class="form-group">
                    <label for="username">Username</label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        value="<?= esc(old('username')) ?>"
                        placeholder="Masukkan username"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="password-field">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-toggle-password="password"
                            aria-label="Tampilkan password"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Masuk
                </button>
            </form>
        </section>
    </main>
</body>
</html>