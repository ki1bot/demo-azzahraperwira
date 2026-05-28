<!DOCTYPE html>
<html lang="id" data-admin-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul ?? 'Login Admin') ?></title>

    <script>
        (function () {
            const tema = localStorage.getItem('tema-admin-yayasan') || 'light';
            document.documentElement.setAttribute('data-admin-theme', tema);
        })();
    </script>

    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #dbe4ee;
            --primary: #136f4f;
            --primary-hover: #0f5d42;
            --input: #ffffff;
            --danger: #dc2626;
            --danger-soft: #fee2e2;
            --success: #15803d;
            --success-soft: #dcfce7;
            --shadow: 0 24px 70px rgba(15, 23, 42, .12);
        }

        [data-admin-theme="dark"] {
            --bg: #0b1120;
            --card: #111827;
            --text: #f8fafc;
            --muted: #94a3b8;
            --border: #273449;
            --primary: #34d399;
            --primary-hover: #10b981;
            --input: #0f172a;
            --danger: #f87171;
            --danger-soft: rgba(248, 113, 113, .12);
            --success: #4ade80;
            --success-soft: rgba(74, 222, 128, .12);
            --shadow: 0 24px 70px rgba(0, 0, 0, .35);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 18% 18%, rgba(19, 111, 79, .20), transparent 28rem),
                radial-gradient(circle at 80% 20%, rgba(251, 191, 36, .15), transparent 24rem),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-shell {
            width: min(1080px, 100%);
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            min-height: 620px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 34px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .login-hero {
            position: relative;
            padding: 44px;
            color: #ffffff;
            background:
                linear-gradient(135deg, rgba(19, 111, 79, .94), rgba(15, 93, 66, .94)),
                url("<?= base_url('assets/img/home/home.jpg') ?>");
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .login-logo {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .18);
            font-weight: 900;
        }

        .login-brand h1 {
            margin: 0;
            font-size: 22px;
            line-height: 1.2;
        }

        .login-brand p {
            margin: 5px 0 0;
            opacity: .84;
            font-size: 13px;
        }

        .login-copy h2 {
            margin: 0 0 16px;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1;
            letter-spacing: -.05em;
        }

        .login-copy p {
            margin: 0;
            max-width: 520px;
            line-height: 1.7;
            opacity: .86;
        }

        .login-panel {
            padding: 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .panel-header {
            margin-bottom: 28px;
        }

        .panel-header h2 {
            margin: 0 0 10px;
            font-size: 32px;
            letter-spacing: -.04em;
        }

        .panel-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .form {
            display: grid;
            gap: 16px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: 850;
        }

        .form-control {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 16px;
            outline: none;
            color: var(--text);
            background: var(--input);
            transition: .18s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(19, 111, 79, .12);
        }

        .btn {
            min-height: 50px;
            border: 0;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 900;
            color: #ffffff;
            background: var(--primary);
            box-shadow: 0 16px 28px rgba(19, 111, 79, .20);
            transition: .18s ease;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .theme-toggle {
            position: fixed;
            right: 22px;
            top: 22px;
            min-height: 42px;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 8px 14px;
            color: var(--text);
            background: var(--card);
            cursor: pointer;
            font-weight: 850;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .10);
        }

        .alert {
            padding: 13px 15px;
            border-radius: 16px;
            margin-bottom: 16px;
            font-weight: 750;
            line-height: 1.55;
        }

        .alert-error {
            color: var(--danger);
            background: var(--danger-soft);
        }

        .alert-success {
            color: var(--success);
            background: var(--success-soft);
        }

        @media (max-width: 880px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .login-hero {
                min-height: 280px;
            }
        }

        @media (max-width: 560px) {
            body {
                padding: 14px;
            }

            .login-hero,
            .login-panel {
                padding: 28px;
            }

            .login-shell {
                border-radius: 26px;
            }
        }
    </style>
</head>
<body>
    <button type="button" class="theme-toggle" id="themeToggle">Tema</button>

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
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="btn">Masuk</button>
            </form>
        </section>
    </main>

    <script>
        const html = document.documentElement;
        const tombolTema = document.getElementById('themeToggle');

        function setTemaAdmin(tema) {
            html.setAttribute('data-admin-theme', tema);
            localStorage.setItem('tema-admin-yayasan', tema);
            tombolTema.textContent = tema === 'dark' ? 'Tema Gelap' : 'Tema Terang';
        }

        setTemaAdmin(localStorage.getItem('tema-admin-yayasan') || 'light');

        tombolTema.addEventListener('click', function () {
            const temaAktif = html.getAttribute('data-admin-theme') === 'dark' ? 'light' : 'dark';
            setTemaAdmin(temaAktif);
        });
    </script>
</body>
</html>