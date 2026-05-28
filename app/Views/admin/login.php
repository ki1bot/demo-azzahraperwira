<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>
        <?= esc($judul ?? 'Login Admin') ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .pembungkus-login {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kotak-login {
            width: 360px;
            background: #ffffff;
            border-radius: 10px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .kotak-login h1 {
            margin: 0 0 20px;
            font-size: 24px;
        }

        .grup-form {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 11px;
            border: 0;
            border-radius: 6px;
            background: #1f2937;
            color: #ffffff;
            cursor: pointer;
            font-weight: bold;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>
    <div class="pembungkus-login">
        <div class="kotak-login">
            <h1>Login Admin</h1>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="grup-form">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= old('username') ?>" autocomplete="username" required>
                </div>

                <div class="grup-form">
                    <label>Password</label>
                    <input type="password" name="password" autocomplete="current-password" required>
                </div>

                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>
</body>

</html>